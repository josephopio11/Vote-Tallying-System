<?php

namespace Admin\Controllers;

use CodeIgniter\API\ResponseTrait;
use Admin\Models\AdminModel;

class Admin extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------

    public function __construct()
    {
        helper(['Admin\admin']);
    }

    //--------------------------------------------------------------------
    /**
     * view default page = admin 
     * admin   
     */
    public function index()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => 'ccc50d6']);

        $data                 = ['page_title' => lang('admin._page_admin')];
        $data['breadcrumb'][] = ['url' => admin_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('admin._page_admin'), 'class' => 'active'];

        $this->_render('admin', $data);
    }
    //--------------------------------------------------------------------
    /**
     * view page = admin
     * Admin  
     */
    public function admin()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '0673883']);

        $data                 = ['page_title' => lang('admin._page_admin')];
        $data['breadcrumb'][] = ['url' => admin_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('admin._page_admin'), 'class' => 'active'];

        $this->_render('admin', $data);
    }

    //--------------------------------------------------------------------
    /**
     * create or update
     * @return json
     */
    public function save($form_slug, $admin_id = '')
    {
        $data       = $this->request->getPost();
        $validation = \Config\Services::validation();

        //---------------------------------------------------------------------//
        //For form_slug=admin pageSlug=admin
        if($form_slug === 'admin')
        {

            // admin form Validations and security
            $validation->setRules([
                'avatar'        => ['label' => lang('admin.avatar'), 'rules'=>"permit_empty|integer|max_length[11]"],
                'firstname'     => ['label' => lang('admin.firstname'), 'rules'=>"required|max_length[32]|alpha_numeric_space_turkish"],
                'lastname'      => ['label' => lang('admin.lastname'), 'rules'=>"permit_empty|max_length[32]|alpha_numeric_space_turkish"],
                'email'         => ['label' => lang('admin.email'), 'rules'=>"required|valid_email|max_length[96]"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['avatar', 'firstname', 'lastname', 'email', 'admin_id'];
            $data             = array_intersect_key($data, array_flip($filterFormFields));
            //----------------------------------------------------------------//

        }
        //---------------------------------------------------------------------//
        //For form_slug=admin_password pageSlug=admin
        elseif($form_slug === 'admin_password')
        {
            
            //This form con not editable
            if (empty($admin_id))
            {
                //Dissalowed Form
                log_message('critical', "SECURITY: admin_password Disallowed form view request");
                return $this->fail('This form can not addable.', 400, lang('home.error_validation_form'));
            }

            // admin_password form Validations and security
            $validation->setRules([
                'password'      => ['label' => lang('admin.password'), 'rules'=>"required|string|max_length[255]"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['password', 'admin_id'];
            $data             = array_intersect_key($data, array_flip($filterFormFields));
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * password PASSWORD 
            */
            //----------------------------------------------------------------//

            if(!empty($data['password']))
            {
                $data['password']  = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            else
            {
                unset($data['password'] );
            }
            //----------------------------------------------------------------//

        }
        //---------------------------------------------------------------------//
        else
        {
            //not matched
            log_message('error', "SECURITY: $form_slug form not founded");
            return $this->failNotFound("$form_slug form not found");
        }

        $AdminModel = new AdminModel();

        try
        {
            $AdminModel->save($data);
        }
        catch (\Exception $e)
        {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->fail($e->getMessage(), 400, lang('home.error_validation_form'));
        }
        
        if(empty($admin_id))
        {
            $admin_id = $AdminModel->getInsertID();
        }

        return $this->respondCreated(['id' => $admin_id, 'message' => lang('home.saved')]);
    }
 
    //--------------------------------------------------------------------

    /**
     * Read admin data
     * Functions adds DT_RowId variable to each row for datatables.net
     * 
     * Search Contions may change according to $pageSlug
     * 
     * @param string $pageSlug
     * @return array
     * 
     */
    public function readAdmin($pageSlug)
    {

        $pageList = ['admin'];
        $pageSlug = trim($pageSlug);

        if (!in_array($pageSlug, $pageList))
        {
            return $this->response->setJSON(['error' => 'Invalid Page Name']);
        }
            
        session();

        $_SESSION['draw'] =  (int)($draw = $_SESSION['draw'] ?? 1) + 1;

        $start        = intval($_POST['start'] ?? $_GET['start'] ?? 0); 
        $length       = intval($_POST['length'] ?? $_GET['length'] ?? 200);
        $order        = $this->request->getPostGet('order'); //asc desc
        $order_dir    = (isset($order[0]['dir']) && in_array($order[0]['dir'], ['asc', 'desc'])) ? $order[0]['dir'] : 'desc';
        $order_column = filter_var($order[0]['name'] ?? NULL, FILTER_SANITIZE_STRING);

        $model      = new AdminModel();
        $primaryKey = $model->primaryKey;

        $table_colons = $model->getAllowedFields();
 
        // ---------------------------------------------------------------------
        // Form Search Filter
        $formFilter  = $this->request->getPostGet('formFilter');
        $filterArray = null;
        $search_text = null;
 
        if (!empty($formFilter) && is_string($formFilter))
        {
            parse_str($formFilter, $filterArray);
            
            //filterSearch is general input search used in pageview
            if (isset($filterArray['filterSearch']) && !empty($filterArray['filterSearch']))
            {
                $search_text = trim($filterArray['filterSearch']);
            }
        }
        else
        {
            //Standart datatable.net $search['value'] input. used in subtable.
            $search = $this->request->getPost("search");
            if (!empty($search) && !empty($search['value']))
            {
                $search_text = trim($search['value']);
            }
        }
        // ---------------------------------------------------------------------

        //--------------------------------------------------------------------//
        // Page admin
        //--------------------------------------------------------------------//

        if($pageSlug === 'admin')
        {
            $select_text       = "admin.*";
            $multipleFields    = [];

        }
        //----------------------------oo----------------------------------//


        $model->select($select_text);

        //---------------------------------------------------------------------//
        //OTHER FORM SEARCH OPTIONS
        //---------------------------------------------------------------------//

        if (!empty($filterArray) && is_array($filterArray))
        {
            foreach ($filterArray as $filterField => $filterValue)
            {

                if (!is_array($filterValue))
                {
                    $filterValue = trim($filterValue);
                }

                if (empty($filterValue) && !is_numeric($filterValue))
                {
                    continue;
                }

                if ($filterField === 'daterangefilter' && !empty($filterValue))
                {
                    foreach ($filterValue as $dateField => $dateRange)
                    {
                        $exp = explode(' - ', $dateRange);
                        if (count($exp) === 2)
                        {        
                            $_GET['dateRangeStart'][$dateField] = $exp[0];
                            $_GET['dateRangeEnd'][$dateField]   = $exp[1];
                        }
                    }
                    continue;
                }

                if(!in_array($filterField, $table_colons) || in_array($filterField, ['filterSearch', 'status', 'deleted_at']))
                {
                    continue;
                }

                if (in_array($filterField, $multipleFields))
                {
                    if(is_array($filterValue))
                    {
                        $model->groupStart();
                        foreach ($filterValue as  $fvalue)
                        {
                           $model->like($filterField, filter_var($fvalue, FILTER_SANITIZE_STRING)); 
                        }
                        $model->groupEnd();
                    }
                    else
                    {
                        $model->groupStart();
                        $model->like($filterField, filter_var($filterValue, FILTER_SANITIZE_STRING)); 
                        $model->groupEnd();
                    }
                }
                elseif (!is_array($filterValue) || is_numeric($filterValue))
                {
                    $model->where("admin.$filterField", trim(filter_var($filterValue, FILTER_SANITIZE_STRING)));
                }
            }
        }
        //Show Allways active status if not filtered
        if (!isset($filterArray['status']))
        {
            $model->where('admin.status', '1');
        }
        else
        {
            $model->where('admin.status', $filterArray['status']);
        }
        if (isset($filterArray['deleted_at']) && $filterArray['deleted_at'] === '1')
        {
            $model->onlyDeleted();
        }
        else
        {
            $model->where('admin.deleted_at', NULL);
        }

        //---------------------------------------------------------------------//
        /**
         * dateRangeStart and dateRangeEnd used in statistic page. 
         * Also you can use for datatable filter.
         * Get Request E.g
         * dateRangeStart[created_at]=2020-01-01&dateRangeEnd[created_at]=2020-03-02
         */

        $dateRangeStart = $_GET['dateRangeStart'] ?? $_POST['dateRangeStart'] ?? NULL;

        if (!empty($dateRangeStart) && is_array($dateRangeStart))
        {
            foreach ($dateRangeStart as $key_field => $fieldValue)
            {
                if (in_array($key_field, $table_colons) && !empty($fieldValue))
                {
                    $fieldValue = date( "Y-m-d", strtotime(trim($fieldValue)));
                    $model->where("admin.$key_field >=", $fieldValue);
                }
            }
        }

        $dateRangeEnd = $_GET['dateRangeEnd'] ?? $_POST['dateRangeEnd'] ?? NULL;

        if (!empty($dateRangeEnd) && is_array($dateRangeEnd))
        {
            foreach ($dateRangeEnd as $key_field => $fieldValue)
            {
                if (in_array($key_field, $table_colons) && !empty($fieldValue))
                {
                    $fieldValue = date( "Y-m-d", strtotime(trim($fieldValue)));
                    $model->where("admin.$key_field <=", $fieldValue .' 23:59:59');
                }
            }
        }
        //---------------------------------------------------------------------//

        //==========SORT==========//
        if (!empty($order_column) && in_array($order_column, $table_colons))
        {
            $model->orderBy($order_column, $order_dir);
        }
        else
        {
            $model->orderBy($primaryKey, 'DESC');
        }

        //==========LIMIT==========//
        if($length > 0)
        {
            $model->limit($length, $start);
        }            

        //==========GET RESULT==========//
        $db_result = $model->get()->getResult();

        //==========RETURN DATA==========//
        $getLastQuery  = $model->showLastQuery();
        $unlimited     = explode('LIMIT', $getLastQuery)[0];
        $select_sql    = "SELECT COUNT($primaryKey) as count FROM ($unlimited) AS subquery";
        $iTotalRecords = $model->query($select_sql)->getRow()->count;

        if (!empty($db_result))
        {
            foreach ($db_result as $key => $value)
            {
                $db_result[$key]->DT_RowId = $value->$primaryKey;

                //--------------------------------------------------------------------//
                // Page admin
                //--------------------------------------------------------------------//

                if($pageSlug === 'admin')
                { 

                    //------------------------------------------------------------------//
                    // Get File Data From FileID
                    // Limit 1
                    //------------------------------------------------------------------//
                    $fileService = \Admin\Config\Services::file();

                    if(!empty($value->avatar) && !empty($getFiles = $fileService->getAllFile($value->avatar, 1, 'sort_order')))
                    {
                        $db_result[$key]->avatar_c4_url_icon = $getFiles[0]['url_icon'];
                        $db_result[$key]->avatar_c4_url_thumb = $getFiles[0]['url_thumb'];
                        $db_result[$key]->avatar_c4_url_download = $getFiles[0]['url_download'];
                        $db_result[$key]->avatar_c4_other = $getFiles;
                    }
                    else
                    {
                        $db_result[$key]->avatar = '';
                        $db_result[$key]->avatar_fileInfo = []; 
                    }
                    //------------------------------------------------------------------//

                } //endif

            }
        }

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => intval($iTotalRecords),
            'recordsFiltered' => intval($iTotalRecords),
            //'sql' => $getLastQuery,
            'data'            => $db_result
        ];
        return $this->response->setJSON($result);

    }

    //--------------------------------------------------------------------
    /**
     * Delete admin by id
     * @param mix $id
     * @return mixed
     */
    public function delete($id)
    {
        if (empty($id))
        {
            return $this->fail('ID can not be empty');
        }
        if (!is_numeric($id))
        {
            log_message('critical', "SECURITY: Delete ID is not numeric ID: " . esc($id) );
            return $this->fail('ID must be numeric');
        }

        $AdminModel = new AdminModel();
        if ($AdminModel->delete($id, false) === false)
        {
            log_message('error', "Error: $id ID AdminModel Delete Error");
            return $this->fail($AdminModel->errors());
        }

        return $this->respondDeleted(['id' => $id]);
    }

    //--------------------------------------------------------------------

    /**
     * Show form by formSlug
     * @param string $formSlug
     * @return html
     */
    public function showForm($formSlug, $id = null)
    {
        $formSlug = trim($formSlug);

        $data['page_title'] = lang('admin._form_' .$formSlug);
        $data['formData'] = $_POST;
        
        // -----------------------------------
        //breadcrumb if form is showed in Page
        $data['breadcrumb'][] = ['url' => admin_url('home/index'), 'title' => lang('home.dashboard')];

        if($formSlug === 'admin')
        {
            $data['breadcrumb'][] = ['url' => admin_url('admin/admin'), 'title' => lang('admin._page_admin')];
            $data['breadcrumb'][] = ['title' => lang('admin._form_admin'), 'class' => 'active'];
        }
        elseif($formSlug === 'admin_password')
        {
            $data['breadcrumb'][] = ['url' => admin_url('admin/admin'), 'title' => lang('admin._page_admin')];
            $data['breadcrumb'][] = ['title' => lang('admin._form_admin_password'), 'class' => 'active'];
        }
        else
        {
            log_message('error', "SECURITY: $formSlug form not founded");
            return $this->failNotFound("$formSlug not founded");
        }

        if (!empty($id))
        {
            $AdminModel = new AdminModel();
            
            $data['formData'] += $AdminModel->find($id) ?? [];
        }

        $copy      = (int) $this->request->getGet('copy');

        if (!empty($copy))
        {
            $AdminModel = new AdminModel();
            
            $data['formData'] += $AdminModel->find($copy);
            
            if(isset($data['formData']['admin_id']))
            {
                unset($data['formData']['admin_id']);
            }
        }

        

        $this->_render('form/' . $formSlug, $data);
    }

    //--------------------------------------------------------------------

    public function uploadFile($formSlug, $fieldName)
    {
        $formList = ['admin', 'admin_password'];

        if (!in_array($formSlug, $formList))
        {
            return $this->failNotFound("$formSlug not founded");
        }
            
        $fileService = \Admin\Config\Services::file();

        if($fieldName === 'avatar')
        {
            if (!$this->validate(['file' => ['label' => lang('admin.avatar'), 'rules' => 'uploaded[file]|is_image[file]|max_size[file,1024]|ext_in[file,gif,jpg,jpeg,png]|max_dims[file,220,220]']]))
            {
                return $this->fail($this->validator->getErrors(), 400);
            }
            
            $return = $fileService->upload("admin/$fieldName", true);
        }
       
        

        if (isset($return['upload_data']))
        {
            return $this->respond($return);
        }
        else
        {
            return $this->fail($return);
        }

    }

    //--------------------------------------------------------------------

    public function deleteFile($file_id)
    {
        if (!is_numeric($file_id))
        {
            return $this->failValidationError(lang('home.error_invalid_id'));
        }
    
        $fileService = \Admin\Config\Services::file();

        $fileService->deleteFile((int) $file_id);

        return $this->respondDeleted(['id' => $file_id]);
    }

    //--------------------------------------------------------------------

    function updateFileOrder()
    {
        $order_ids = $this->request->getPost('order');        
        $fileService = \Admin\Config\Services::file();
        $fileService->updateFileOrders($order_ids);

        return $this->respond(['message' => lang('home.saved')]);
    }

    //--------------------------------------------------------------------
    /**
     * Update single field of admin 
     * 
     * @param int $id
     * @return mix
     */
    public function update($id)
    {
        if (!is_numeric($id))
        {
            log_message('critical', "SECURITY: Update ID is not numeric ID: " . esc($id) );
            return $this->fail('ID must be numeric');
        }
        $data = $this->request->getPost();
        //allowed update filelds
        $batchList = ['status', 'deleted_at'];

        //clear the post data
        $array_diff = array_diff(array_keys($data), $batchList);
        if (!empty($array_diff))
        {
            log_message('critical', 'SECURITY: NotAllowed update attempt');

            foreach ($array_diff as $value)
            {
                unset($data[$value]);
            }
        }

        if (empty($data))
        {
            log_message('error', 'ERROR: Update Post Data is Empty');
            return $this->fail(lang('home.error_data_empty'), 400, lang('home.error_data_empty'));
        }

        $model = new AdminModel();
        

        //validation
        if(isset($data['status']))
        {
            if (!$this->validate([
                'status' => ['label' => lang('admin.status'), 'rules' => 'required|integer|max_length[1]|in_list[1,2]'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['deleted_at']))
        {
            if($data['deleted_at'] === '1')
            {
                $model->delete($id, false);
                return  $this->respondDeleted(['id'=>$id]);                
            }
            else
            {
                $data['deleted_at'] = null;
            }
        }
        try
        {
            $model->update($id, $data);
        }
        catch (\Exception $e)
        {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->fail($e->getMessage(), 400, $e->getMessage());
        }

        return $this->respond(['message' => lang('home.updated'), 'id' => $id]);
    }

   //--------------------------------------------------------------------
    /**
     * Read statistic Card Data
     * 
     * @param string $cardSlug
     * @return json
     */
    public function readStatistic($pageSlug, $cardSlug)
    {
        $cardData = [];

        return $this->response->setJSON($cardData);
    }
 
    //--------------------------------------------------------------------

    /**
     * Return module lang used in JS file.
     */
    public function langJS()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '5fc177e']);

        $conf   = new \Config\App();
        $locale = $this->request->getLocale();

        //Load Home Lang File
        $langFile = ROOTPATH . 'admin/Language/' . $locale . '/admin.php';

        if (!file_exists($langFile))
        {
            //Check default lang file
            $langFile = ROOTPATH . 'admin/Language/' . $conf->defaultLocale . '/admin.php';

            if (!file_exists($langFile))
            {
                $langFile = null;
            }
        }

        $langArray['panel_language'] = $locale;
        $langArray['panel_url'] = admin_url(null, $locale); 

        if (!empty($langFile))
        {
            $langArray += require $langFile; // Current local language
        }
        else
        {
            log_message('alert',  "There is no $locale  lang file");
            $langArray['error'] = "There is no $locale  lang file";
        }

        $this->response->setContentType('application/x-javascript');
        echo 'var LANG_admin = ' . json_encode($langArray, JSON_PRETTY_PRINT);
    }

    //--------------------------------------------------------------------

    private function _render($page, $data = [])
    {
        helper('form');

        $data['table_name']  = 'admin';

        if ($this->request->isAJAX())
        {
            try
            {
                echo admin_view('admin/' . $page, $data);
            }
            catch (\Exception $e)
            {
                log_message('alert', '[ERROR] {exception}', ['exception' => $e]);
                return $this->fail($e->getMessage(), 400, $e->getMessage());
            }
        }
        else
        {
            try
            {
                echo admin_view('themes/' . $this->theme . '/header', $data);
                echo admin_view('admin/' . $page, $data);
                echo admin_view('themes/' . $this->theme . '/footer', $data);
            }
            catch (\Exception $e)
            {
                log_message('alert', '[ERROR] {exception}', ['exception' => $e]);
                throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
            }
        }
    }

    //--------------------------------------------------------------------

}