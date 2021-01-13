<?php
/**
 * Basic Authication Service
 * 
 *   * 
 */

namespace Admin\Services;

use CodeIgniter\Config\BaseService;
use Admin\Models\C4_fileModel;

class FileService extends BaseService
{

    protected $model      = null;
    protected $error      = [];
    protected $maxSize    = 10; //in mb
    protected $invalidExt = ['php', 'php3', 'php4', 'phps', 'phtml', 'js', 'html', 'xhtml', 'htm', 'htaccess', 'env'];
    protected $isPublic   = true;
    protected $folderName = ''; //Folder name inside UPLOAD
    protected $fileData = [];
    
    //--------------------------------------------------------------------

    public function __construct()
    {
        helper('Admin\c4_file');
    }

    // -------------------------------------------------------------------------

    function upload($folderName = '', $isPublic = null)
    {
        $request = \Config\Services::request();
        $file    = $request->getFile('file');
        
        if($isPublic != null)
        {
            $this->setIsPublic($isPublic);
        }
        if(!empty($folderName))
        {
            $this->setFolderName($folderName);
        }

        $getExtension = $file->getExtension();

        // ---------------------------------------------------------------------
        /**
         * General Purpose Security
         */
        // ---------------------------------------------------------------------
        if (in_array(strtolower($getExtension), $this->invalidExt))
        {
            log_message('critical', "SECURITY: {$getExtension} file upload attempt");
            return $this->setError("You Can not upload {$getExtension} file", 'critical');
        }

        if ($file->getSizeByUnit('mb') > $this->maxSize)
        {
            return $this->setError('Only less than ' . $this->maxSize . ' mb file upload allowed');
        }

        // ---------------------------------------------------------------------

        if ($file->isValid() && !$file->hasMoved())
        {

            $newName   = $file->getRandomName();
            $move_path = $this->getMovePath();

            $file->move($move_path, $newName);

            $type = \Config\Mimes::guessTypeFromExtension($getExtension);

            $file_data['name']         = $newName;
            $file_data['originalName'] = $file->getClientName();
            $file_data['extension']    = $getExtension;
            $file_data['isPublic']     = $this->getIsPublic() ? '1' : '0';
            $file_data['size']         = $file->getSizeByUnit('mb');
            $file_data['type']         = $type;
            $file_data['isImage']      = ($isImage                   = (mb_strpos($type, 'image') === 0) ? 1 : 0);
            $file_data['path']         = "uploads/{$folderName}";
            $file_data['fullPath']     = "uploads/{$folderName}/{$newName}";

            $icon_url   = $this->getIcon($getExtension);
            $thumb_name = '';

            if ($isImage && $this->getIsPublic())
            {
                try
                {
                    $thumb_name = 'thumb_' . $newName;

                    service('image')
                            ->withFile($move_path . $newName)
                            ->resize(50, 50)
                            ->save($move_path . $thumb_name);

                    $icon_url           = site_url("uploads/{$folderName}/{$thumb_name}");
                    $file_data['thumb'] = $thumb_name;
                }
                catch (CodeIgniter\Images\ImageException $e)
                {
                    return $e->getMessage();
                }
            }

            $file_id = $this->saveFile($file_data);

            $downloadUrl = site_url("uploads/{$folderName}/$newName");
            if (!$this->getIsPublic())
            {
                $downloadUrl = admin_url("general/downloadfile/$file_id");
            }

            $file_data['file_id']     = $file_id;
            $file_data['downloadUrl'] = $downloadUrl;
            $file_data['icon_url']    = $icon_url;
            $file_data['deleteUrl']   = admin_url(explode('/', $folderName)[0] . "/deleteFile/$file_id");

            return ['upload_data' => $file_data];
        }
        else
        {
            return $this->setError($file->getErrorString());
        }
    }

    // -------------------------------------------------------------------------

    function updateFileOrders($order_ids)
    {

        $FileModel = new C4_fileModel();
        $order     = 0;

        if (!empty($order_ids) && is_array($order_ids))
        {
            foreach ($order_ids as $file_id)
            {
                if (!empty($file_id))
                {
                    $file_id = intval($file_id);

                    $FileModel->update($file_id, ['sort_order' => $order]);
                    $order++;
                }
            }
        }
    }

    // -------------------------------------------------------------------------
    
    function getIcon($extention)
    {
        $file_icons['css']        = 'images/file_icons/css.svg';
        $file_icons['csv']        = 'images/file_icons/csv.svg';
        $file_icons['doc']        = 'images/file_icons/doc.svg';
        $file_icons['html']       = 'images/file_icons/html.svg';
        $file_icons['javascript'] = 'images/file_icons/javascript.svg';
        $file_icons['jpg']        = 'images/file_icons/jpg.svg';
        $file_icons['mp4']        = 'images/file_icons/mp4.svg';
        $file_icons['pdf']        = 'images/file_icons/pdf.svg';
        $file_icons['xml']        = 'images/file_icons/xml.svg';
        $file_icons['zip']        = 'images/file_icons/zip.svg';
        $file_icons['png']        = 'images/file_icons/png.svg';
        $file_icons['png']        = 'images/file_icons/png.svg';
        $file_icons['404']        = 'images/file_icons/404.svg';

        $resources_url = resources_url();

        return isset($file_icons[$extention]) ? ($resources_url . $file_icons[$extention]) : ($resources_url . $file_icons['doc']);
    }     

    // -------------------------------------------------------------------------
    /**
     * 
     * @param type $errorString
     * @param type $errorCode
     * @return boolean
     * 
     *  - emergency
     *  - alert
     *  - critical
     *  - error
     *  - warning
     *  - notice
     *  - info
     *  - debug
     */
    protected function setError($errorString, $errorCode = 'warning')
    {
        $this->error[$errorCode] = $errorString;
        return false;
    }

    // -------------------------------------------------------------------------

    protected function getMovePath()
    {

        $move_path = WRITEPATH . 'uploads/' . $this->getFolderName();

        if ($this->getIsPublic())
        {
            $move_path = FCPATH . 'uploads/' . $this->getFolderName();
        }

        return $move_path;
    }

    // -------------------------------------------------------------------------
    protected function setIsPublic($isPublic)
    {
        $this->isPublic = boolval($isPublic);
    }

    protected function getIsPublic()
    {
        return boolval($this->isPublic);
    }

    // -------------------------------------------------------------------------
    protected function setFolderName($foldername)
    {
        $this->folderName = $foldername;
    }

    protected function getFolderName()
    {
        return rtrim($this->folderName . '/') . '/';
    }

    // -------------------------------------------------------------------------
    
    function getFileID()
    {
         return $this->fileData['c4_file_id'] ?? null;
    }    
    // -------------------------------------------------------------------------
    
    function saveFile(array $data)
    {
         return saveC4_file($data);
    }

    // -------------------------------------------------------------------------
    
    function deleteFile($where)
    {
         return deleteC4_file($where);
    }

    // -------------------------------------------------------------------------
    
    
    function saveFromPath($fullPath)
    {
        
        $file = new \CodeIgniter\Files\File($fullPath);
        $fileData['fullPath']     = str_replace(WRITEPATH, '', $fullPath);
        $fileData['name']         = $file->getFilename();
        $fileData['originalName'] = $file->getFilename();
        $fileData['isImage']      = 0;
        $fileData['isPublic']     = 0; //Means save in WRITEPATH
        $fileData['extension']    = $file->guessExtension();
        $fileData['size']         = $file->getSize('mb');
        $fileData['type']         = $file->getMimeType();
        $fileData['path']         = str_replace(WRITEPATH, '', $file->getPath());
        $fileData['thumb']        = '';
        $fileData['c4_file_id']  = $this->saveFile($fileData);
        
        $this->fileData = $fileData;
        
        return $fileData['c4_file_id'];
    }
    
    // -------------------------------------------------------------------------

    function getFile($where)
    {
        $this->fileData = getC4_file($where);

        if (!empty($this->fileData))
        {
            $this->fileData = $this->analyzeFiledata($this->fileData);
        }

        return $this->fileData;
    }
    
    // -------------------------------------------------------------------------
    
    function getAllFile($where = null, $limit=null, $orderBy = 'c4_file_id')
    {

        $all_files = getAllC4_file($where, $limit, $orderBy);
        
        if(empty($all_files))
        {
            return false;
        }
        
        foreach($all_files as $key => $fileData)
        {
            $all_files[$key] =  $this->analyzeFiledata($fileData);
        }
        
        return $all_files;
    }
    
    
    // -------------------------------------------------------------------------

    public function analyzeFiledata($fileDBData)
    {
        if (empty($fileDBData) || !isset($fileDBData['c4_file_id']))
        {
            $fileDBData['url_thumb']    = $this->getIcon('404');
            $fileDBData['url_download'] = '';
            $fileDBData['reelpath'] = '';
            return $fileDBData;
        }

        $fileDBData['file_id'] = $fileDBData['c4_file_id'];

        // Get Thumb
        $fileDBData['url_thumb'] = $this->getIcon($fileDBData['extension']);

        if (intval($fileDBData['isImage']) === 1 && intval($fileDBData['isPublic']) && !empty($fileDBData['thumb']))
        {
            $fileDBData['url_thumb'] = site_url($fileDBData['path'] . DIRECTORY_SEPARATOR . $fileDBData['thumb']);
        }

        //Get Download Url
        if (intval($fileDBData['isPublic']) === 1)
        {
            $fileDBData['url_download'] = site_url($fileDBData['path'] . DIRECTORY_SEPARATOR . $fileDBData['name']);
            $fileDBData['reelpath'] = FCPATH . $fileDBData['path'] . DIRECTORY_SEPARATOR . $fileDBData['name'];
        }
        else
        {
            $fileDBData['url_download'] = admin_url('home/downloadfile/' . DIRECTORY_SEPARATOR . $fileDBData['file_id']);
            $fileDBData['reelpath'] = WRITEPATH . $fileDBData['path'] . DIRECTORY_SEPARATOR . $fileDBData['name'];
        }

        $fileDBData['url_icon'] = $this->getIcon($fileDBData['extension']);
        
        return $fileDBData;
    }

}
