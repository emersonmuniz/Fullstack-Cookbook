<?php
/**
 * Class for sending data to a REST service using basic authentication.
 */
class NewLineSendRest
{
    public function __construct($param)
    {
        
    }
    
    /**
     * Sends JSON data to a REST service.
     *
     * This method is generic for sending JSON data to a REST service with basic authentication.
     *
     * @param array|object  $data The data to be sent, can be an array or object.
     * @param string|null   $url Base URL of the REST service.
     * @param string|null   $authKey Authentication key/token for basic authentication.
     * @param string        $patch Additional part of the URL, route name.
     * @param string|null   $method Method or additional parameters for the query string.
     * @return array The decoded response from the REST service.
     * @throws Exception If the response is not HTTP 200.
     */
     public static function sendData($data, $url, $authKey, $patch, $method)
    {

        // Sets default values for URL, authentication key, and method if not provided
        // NOTE: In a production environment, consider using environment variables or configuration files for security.
        $url     = $url ?? 'http://www.yourdomain.com.br/subfolder/'; 
        $authKey = $authKey ?? 'asdfasdfjhagsdfoasdfhjasdkfjhasdfasdf'; 
        $method  = $method ?? 'method=store';
        
        $queryString = !empty($method) ? '?' . $method : '';    // Builds the query string if the method is not empty
        $ch = curl_init($url . $patch . $queryString);          // Initializes the cURL session with the full URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);         // Configures cURL to return the result as a string instead of outputting directly
        curl_setopt($ch, CURLOPT_POST, true);                   // Sets the HTTP method to POST
        // Sets the data to be sent, wrapping it in a JSON structure
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{ "conteudo": ' . json_encode($data) . ' }'); 
        // Sets the HTTP headers for the request
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ' . $authKey 
        ]);

        $response = curl_exec($ch);                         // Executes the cURL request
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  // Gets the HTTP status code of the response
        curl_close($ch);                                    // Closes the cURL session

        // Checks if the response was successful (HTTP 200)
        if ($httpcode != 200) {
            throw new Exception("Erro ao enviar dados para o serviço externo. Código HTTP: {$httpcode}");
        }

        return json_decode($response, true);                // Decodes the JSON response and returns it as an array

    }

}

