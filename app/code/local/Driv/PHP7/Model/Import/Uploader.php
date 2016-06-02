<?php
/**
 * Created on: 08.12.15.
 * @copyright Driv d.o.o. (http://drivdigital.no)
 * @author Driv Team
 * @license MIT
 */ 
class Driv_PHP7_Model_Import_Uploader extends Mage_ImportExport_Model_Import_Uploader
{
    protected function _validateFile()
    {
        $filePath = $this->_file['tmp_name'];
        $this->_fileExists = false;
        if (is_readable($filePath)) {
            $this->_fileExists = true;
        }

        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        if (!$this->checkAllowedExtension($fileExtension)) {
            throw new Exception('Disallowed file type.');
        }
        //run validate callbacks
        foreach ($this->_validateCallbacks as $params) {
            if (is_object($params['object']) && method_exists($params['object'], $params['method'])) {
                $params['object']->{$params['method']}($filePath);
            }
        }
    }
}