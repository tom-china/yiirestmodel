<?php
/**
 * ApiResponseProvider is a base class for sendig information in proper format to end user.
 * 
 * Derived classes mainly need to implement two methods: {@link sendData} and
 * {@link accessDenied}.
 * 
 * @author Oleg Gutnikov <goodnickoff@gmail.com>
 * @package api
 */

abstract class ApiResponseProvider
{
    const MODE_JSON = 1;
    const MODE_XML = 2;
    
    /**
     * Constructor.
     * @param string $format the format of data (e.g. 'xml'). If not set,
     * JSON format will be used.
     */
    /*public function __construct($format = 'json')
    {
        switch (mb_strtolower(Yii::app()->request->getQuery('format', $format))) {
            case 'xml':
                $this->_mode = self::MODE_XML;
                break;
            case 'json':
                $this->_mode = self::MODE_JSON;
                break;
            default:
                $this->_mode = self::MODE_JSON;
                break;
        }
    }*/

    /**
     * @return ApiResponseProvider Instance based on {@link $_mode} property.
     */
    /*public static function getResponseProvider($format = 'json')
    {
        
        switch ($this->_mode) {
            case self::MODE_JSON:
                return new ApiJsonResponseProvider();
                break;
            case self::MODE_XML:
                return new ApiXmlResponseProvider();
                break;
        }
    }*/

    /**
     * Function converts $data array to appropriate format, sends it to client and terminates the application.
     * Usage example:
     * <pre>
     *   $this->sendData(
     *       array(...),
     *       200,
     *       array(
     *           "Content-Range: items $offset-$limit/$total",
     *           ...
     *       )
     *   );
     * </pre>
     * @param array $data 
     * @param int $status code.
     * @param array $headers http headers array.
     */
    abstract public function sendData($data, $status = null, array $headers=array());
    
    /**
     * Function displays "access denied" message to end users 
     * with 403 http status code and terminates the application.
     * @return null
     */
    public function accessDenied()
    {
        throw new CHttpException('You do not have sufficient permissions to access.', 403);
    }
    
    /**
     * Funcion return HTTP status code message
     * @param int $status status code
     * @return string code message
     */
    protected function _getStatusCodeMessage($status)
    {
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }
}