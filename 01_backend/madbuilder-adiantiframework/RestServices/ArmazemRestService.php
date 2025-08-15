<?php

/**
 * Service class for handling warehouse (Armazem) records via REST.
 * Extends AdiantiRecordService for database operations.
 */
class ArmazemRestService extends AdiantiRecordService
{
    const DATABASE      = 'portaljfs';
    const ACTIVE_RECORD = 'Armazem';
    const ATTRIBUTES    = ['codigo_erp', 'descricao', 'dt_atu', 'dt_del', 'dt_inc', 'id', 'sigla', 'status_reg'];
    
    /**
     * load($param)
     *
     * Loads an Active Record by its ID.
     * 
     * @return array The Active Record as an associative array
     * @param array $param with 'id' key for the object ID
     */
    
    /**
     * delete($param)
     *
     * Deletes an Active Record by its ID.
     * 
     * @return array The operation result
     * @param array $param with 'id' key for the object ID
     */
    
    /**
     * store($param)
     *
     * Saves one or more Active Records.
     * 
     * @return array The operation result, contains either the stored records or error messages
     * @param array $request with 'conteudo' key containing an array of objects to store
     */
    public function store($request)
    {
        $database     = static::DATABASE;
        $activeRecord = static::ACTIVE_RECORD;
    
        $aReturn = [];

        // Convert the 'conteudo' in the request to an array if it exists
        $aStore = (array)$request['conteudo'];
                  
        // Execution and Notification Controls
        $user_id        = 1;               // User ID (I chose not to use session or parameter)
        $param          = [];              // Action for the user
        $action_btn     = NULL;            // Class, method, and parameters
        $texto_btn      = 'OK';
        $icon           = 'fas fa-triangle-exclamation'; // icon
        $dt_notificacao = NULL; //date();

        // Start a database transaction
        TTransaction::open($database);
        try { 
            foreach ($aStore as $aitem) {
                $aTemp = (array)$aitem;
                $ErroModulo = 'REST - Erro Armazem: ' . $aTemp['codigo'];
            
                // Warehouse Processing
                $oProcura = $aTemp['codigo'];
                if (!empty($oProcura)) {
                    // Check if the warehouse exists by ERP code
                    $oTabela = Armazem::where('codigo_erp', '=', $oProcura)->first();     
                    if ($oTabela)  {
                        $aTemp['id'] = $oTabela->id; // Update with existing ID
                    } else {
                        $aTemp['codigo_erp'] = $oProcura;   
                    } 
                }
    
                // Create or update the warehouse record
                $object = new $activeRecord;
                $object->fromArray($aTemp);
                $object->store();
                $aReturn[] = $object->toArray();           
            }
    
            // Close the transaction if all goes well
            TTransaction::close();
        } catch (Exception $e) 
        {
            // If an error occurs, rollback the transaction and prepare error information
            TTransaction::rollback();
            $aReturn[] = $e->getMessage();  
            $texto      = $e->getMessage();
            $titulo     = $ErroModulo;
            SystemNotification::register($user_id, $titulo, $texto, $action_btn, $texto_btn, $icon, $dt_notificacao);
            return $aReturn; 
        }
        return $aReturn;
    }
}