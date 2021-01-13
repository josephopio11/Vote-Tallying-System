<?php
/**
 *  General class is accessible without autication.
 *  You need to know that, this class not in authentication protection
 *  Check Config/routes.php 
 */

namespace Agents\Controllers;

use CodeIgniter\API\ResponseTrait;

class General extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------

    public function __construct()
    {
        
    }

    //--------------------------------------------------------------------

    /**
     * Email Track System
     * Request come here when email opened.
     */

    public function mopened($cid)
    {
        $db = \Config\Database::connect();

        $email_history = $db->table('c4_email_history');
        $email_history->where('cid', $cid);
        $historyData   = $email_history->get()->getRowArray();

        if (!empty($historyData))
        {
            $email_history->where(['cid' => $cid])->update(['is_read' => 1, 'updated_at' => date('Y-m-d H:i:s')]);

            $Email_track = $db->table('c4_email_track');

            $Email_track->insert([
                'c4_email_history_id ' => $historyData['c4_email_history_id'],
                'browser'          => $this->request->getUserAgent(),
                'ip'               => $this->request->getIPAddress(),
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ]);
        }

        $img = FCPATH . 'resources/images/1pixel.png';

        header('Content-Type: image/png');
        header('Content-Length: ' . filesize($img));
        readfile($img);
        exit();
    }
    
    
    //--------------------------------------------------------------------

    /**
     * Get C4_countryModel data
     * @return json
     */
    public function getAllC4_country() 
    {
        $q      = $this->request->getGetPost('search');
        $filter = $this->request->getGetPost('filter');
        $limit  = $this->request->getGetPost('limit');

        if(!is_numeric($limit))
        {
            $limit = 100;
        }
        
        //Return Filter Str to Array
        $filterArray = null;
        if (!empty($filter) && is_string($filter)) 
        {
            parse_str($filter, $filterArray);
        }

        $model = new \Agents\Models\C4_countryModel();
        $allowedFields = $model->getAllowedFields();
        
        if(!empty($q))
        {
            $model->groupStart();
            $model->orLike('name', $q);
            $model->groupEnd();
        }

        $model->orderBy('name', 'asc');

        if (!empty($filterArray)) {
            foreach ($filterArray as $fieldName => $fieldValue) {

                if (in_array($fieldName, [$model->primaryKey, 'status', 'deleted_at', 'created_at', 'updated_at'])) 
                {
                    continue;
                }
                if (! in_array($fieldName, $allowedFields) )
                {
                    continue;
                }
                
                if ( !empty($fieldValue) || is_numeric($fieldValue) ) 
                {
                    $model->where($fieldName, $fieldValue);
                }
            }
        }
        
        return $this->response->setJSON($model->findAll($limit));
    }

    //--------------------------------------------------------------------

    /**
     * Get C4_zoneModel data
     * @return json
     */
    public function getAllC4_zone() 
    {
        $q      = $this->request->getGetPost('search');
        $filter = $this->request->getGetPost('filter');
        $limit  = $this->request->getGetPost('limit');

        if(!is_numeric($limit))
        {
            $limit = 100;
        }
        
        //Return Filter Str to Array
        $filterArray = null;
        if (!empty($filter) && is_string($filter)) 
        {
            parse_str($filter, $filterArray);
        }

        $model = new \Agents\Models\C4_zoneModel();
        $allowedFields = $model->getAllowedFields();
        
        if(!empty($q))
        {
            $model->groupStart();
            $model->orLike('name', $q);
            $model->groupEnd();
        }

        $model->orderBy('name', 'asc');

        if (!empty($filterArray)) {
            foreach ($filterArray as $fieldName => $fieldValue) {

                if (in_array($fieldName, [$model->primaryKey, 'status', 'deleted_at', 'created_at', 'updated_at'])) 
                {
                    continue;
                }
                if (! in_array($fieldName, $allowedFields) )
                {
                    continue;
                }
                
                if ( !empty($fieldValue) || is_numeric($fieldValue) ) 
                {
                    $model->where($fieldName, $fieldValue);
                }
            }
        }
        
        return $this->response->setJSON($model->findAll($limit));
    }
    
    //--------------------------------------------------------------------
    
    /**
    * Terms of service 
    * Get TOS from template
    */
    public function termsOfService()
    {
        $config   = new \Agents\Config\Agents();
        $app  = new \Config\App();

        $termsOfService = getTemplateByName('termsOfService', [
            'panelTitle' => $config->panelTitle,
            'companyName' => $config->panelTitle,
            'baseURL' => $app->baseURL
        ]);

        if (!empty($termsOfService))
        {
            echo $termsOfService['title'];
            echo $termsOfService['content'];
        }
        else
        {
            echo 'There is no content yet!';
        }
    }
    
    //--------------------------------------------------------------------
    
    /**
    * privacy of service 
    * Get privacy from template
    */
    public function privacy()
    {
        $config   = new \Agents\Config\Agents();
        $app  = new \Config\App();

        $privacy = getTemplateByName('privacy', [
            'panelTitle' => $config->panelTitle,
            'companyName' => $config->panelTitle,
            'baseURL' => $app->baseURL
        ]);

        if (!empty($privacy))
        {
            echo $privacy['title'];
            echo $privacy['content'];
        }
        else
        {
            echo 'There is no content yet!';
        }
    }
}
