<?php
/**
 * Class for handling data from a database source and send to a service to export.
 */
class NewLineExport
{
    public function __construct($param)
    {
        
        }
        
        
    /**
     * Processes warehouse data and sends it to an external REST service.
     *
     * This method paginates through warehouse records, retrieves them, and sends them to an external service.
     *
     * @param array $param Array with parameters for the operation, including 'records' for pagination, initial_date and final_date ranges.
     * @return null Returns null, as this method is for side effects (sending data).
     */
    public static function NL_Armazem($param)
    {
        // Define the number of records to process per iteration, with a default of and date range if received in $param
        $recordsQty   = isset($param['records']) && $param['records'] > 0 ? $param['records'] : 5;
        $initialDate  = $param['initial_date'] ?? null;
        $finalDate    = $param['final_date'] ?? null;
        $queryCount   = ' ';
        $count        = 0;
        $loops        = 1;
    
        TTransaction::open('bijfs');                    // Start a transaction with the database
        $conn         = TTransaction::get();
        $querywhere   = '';                             // SQL where clause, left empty for now (to be used for filtering if needed)
        try { 
            $queryCount = 'select count(*) from armazens';    // Count the total number of warehouse records
            $result     = $conn->query($queryCount . $querywhere);
            $countData  = $result->fetch(PDO::FETCH_OBJ);
            $count      = $countData->count ?? 0;
            $loops      = ceil($count / $recordsQty);   // Calculate how many loops are needed based on the record count and quantity per loop

        } catch (Exception $e) {
            TTransaction::rollback();                   // If an error occurs, roll back the transaction and register the error
            SystemNotification::register(1, 'NL - Erro Armazem: ', $e->getMessage(), null, 'OK', 'fas fa-triangle-exclamation', null);
            return null; 
        }
        try {
            // Load records
            $query      = 'select num_armaz as codigo, abrev_armaz as sigla, desc_armaz as descricao from armazens order by num_armaz' . $querywhere;
            $result     = $conn->query($query);
            $objects    = $result->fetchAll(PDO::FETCH_CLASS, "stdClass");
        } catch (Exception $e) {
            TTransaction::rollback();                   // Handle errors during data retrieval
            SystemNotification::register(1, 'NL - Erro Armazem: ', $e->getMessage(), null, 'OK', 'fas fa-triangle-exclamation', null);
            return null; 
        }
        $loop = 0;                                      // Loop through the data in chunks defined by $recordsQty
        while ($loop < $loops) {
            $loop++;
            $start = ($loop - 1) * $recordsQty;
            $end = $recordsQty;
            // Slice the array to get the next batch of records
            $slicedObject = array_slice($objects, $start, $end);
            
            if (!empty($slicedObject)) {
                try {
                // Send the sliced data to the external REST service
                NewLineSendRest::sendData($slicedObject,null,null,'armazem',null);
                } catch (Exception $e) {
                    // Handle errors during data sending
                    SystemNotification::register(1, 'NL - Erro enviando para Servido Externo: ', $e->getMessage(), null, 'OK', 'fas fa-triangle-exclamation', null);
                }
            }
        }
        TTransaction::close();                          // Close the database transaction
        return null;
    }
