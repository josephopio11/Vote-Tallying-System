<?php

namespace Agents\Controllers;

use CodeIgniter\API\ResponseTrait;
use Agents\Models\UsersModel;
use Agents\Models\UsertypeModel;

class Users extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------

    public function __construct()
    {
        helper(['Agents\users', 'Agents\usertype']);
    }

    //--------------------------------------------------------------------
    /**
     * view default page = users 
     * users   
     */
    public function index()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '6d24e14']);

        $data                 = ['page_title' => lang('users._page_users')];
        $data['breadcrumb'][] = ['url' => agents_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('users._page_users'), 'class' => 'active'];

        $this->_render('users', $data);
    }
    //--------------------------------------------------------------------
    /**
     * view page = users
     * Users  
     */
    public function users()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '35f5673']);

        $data                 = ['page_title' => lang('users._page_users')];
        $data['breadcrumb'][] = ['url' => agents_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('users._page_users'), 'class' => 'active'];

        $this->_render('users', $data);
    }

    //--------------------------------------------------------------------
    /**
     * create or update
     * @return json
     */
    public function save($form_slug, $user_id = '')
    {
        $data       = $this->request->getPost();
        $validation = \Config\Services::validation();

        //---------------------------------------------------------------------//
        //For form_slug=users pageSlug=users
        if($form_slug === 'users')
        {

            // users form Validations and security
            $validation->setRules([
                'firstname'     => ['label' => lang('users.firstname'), 'rules'=>"required|max_length[32]|string"],
                'lastname'      => ['label' => lang('users.lastname'), 'rules'=>"required|max_length[32]|string"],
                'gender'        => ['label' => lang('users.gender'), 'rules'=>"required|in_list[male,female]|alpha_dash"],
                'dob'           => ['label' => lang('users.dob'), 'rules'=>"required|valid_date"],
                'nationalID'    => ['label' => lang('users.nationalID'), 'rules'=>"permit_empty|max_length[20]|string"],
                'email'         => ['label' => lang('users.email'), 'rules'=>"required|valid_email|max_length[96]|is_unique[users.email,user_id,{$_POST['user_id']}]"],
                'password'      => ['label' => lang('users.password'), 'rules'=>"permit_empty|string|max_length[255]"],
                'phone'         => ['label' => lang('users.phone'), 'rules'=>"permit_empty|numeric|max_length[15]"],
                'usertype'      => ['label' => lang('users.usertype'), 'rules'=>"required"],
                'avatar'        => ['label' => lang('users.avatar'), 'rules'=>"permit_empty|integer|max_length[20]"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['firstname', 'lastname', 'gender', 'dob', 'nationalID', 'email', 'password', 'phone', 'usertype', 'avatar', 'user_id'];
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

            //----------------------------------------------------------------//
            /**
            * Check usertype for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_usertype'))  && empty(getUsertype($data['usertype'])))
            {
                log_message('error', 'SECURITY: Undefined usertype value posted');
                return $this->fail(['usertype'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
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

        $UsersModel = new UsersModel();

        try
        {
            $UsersModel->save($data);
        }
        catch (\Exception $e)
        {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->fail($e->getMessage(), 400, lang('home.error_validation_form'));
        }
        
        if(empty($user_id))
        {
            $user_id = $UsersModel->getInsertID();
        }

        return $this->respondCreated(['id' => $user_id, 'message' => lang('home.saved')]);
    }
 
    //--------------------------------------------------------------------

    /**
     * Read users data
     * Functions adds DT_RowId variable to each row for datatables.net
     * 
     * Search Contions may change according to $pageSlug
     * 
     * @param string $pageSlug
     * @return array
     * 
     */
    public function readUsers($pageSlug)
    {

        $pageList = ['users'];
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

        $model      = new UsersModel();
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
        // Page users
        //--------------------------------------------------------------------//

        if($pageSlug === 'users')
        {
            $select_text       = "users.*, usertype.usertype as usertype_RELATIONAL_usertype";
            $multipleFields    = [];

            //------------------------------------------------------------------//
            //merge relation fields names to make Sortable
            $table_colons = array_merge($table_colons, ['usertype_RELATIONAL_usertype']);
            //------------------------------------------------------------------//
            //------------------------------------------------------------------//        
            // Left Join Text
            //------------------------------------------------------------------//
            $model->join("(SELECT type_id, usertype FROM usertype WHERE usertype.deleted_at IS NULL AND usertype.status = '1' GROUP BY type_id ORDER BY type_id DESC) usertype", 'usertype.type_id = users.usertype', 'left');

            if (!empty($search_text))
            {
                $search_text = filter_var($search_text, FILTER_SANITIZE_STRING);
                $model->groupStart();
                $model->orLike('users.firstname', $search_text);
                $model->orLike('users.lastname', $search_text);
                $model->orLike('users.email', $search_text);
                $model->orLike('users.phone', $search_text);
                $model->groupEnd();
            }

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
                    $model->where("users.$filterField", trim(filter_var($filterValue, FILTER_SANITIZE_STRING)));
                }
            }
        }
        //Show Allways active status if not filtered
        if (!isset($filterArray['status']))
        {
            $model->where('users.status', '1');
        }
        else
        {
            $model->where('users.status', $filterArray['status']);
        }
        if (isset($filterArray['deleted_at']) && $filterArray['deleted_at'] === '1')
        {
            $model->onlyDeleted();
        }
        else
        {
            $model->where('users.deleted_at', NULL);
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
                    $model->where("users.$key_field >=", $fieldValue);
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
                    $model->where("users.$key_field <=", $fieldValue .' 23:59:59');
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
                // Page users
                //--------------------------------------------------------------------//

                if($pageSlug === 'users')
                { 

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
     * Delete users by id
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

        $UsersModel = new UsersModel();
        if ($UsersModel->delete($id, false) === false)
        {
            log_message('error', "Error: $id ID UsersModel Delete Error");
            return $this->fail($UsersModel->errors());
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

        $data['page_title'] = lang('users._form_' .$formSlug);
        $data['formData'] = $_POST;
        
        // -----------------------------------
        //breadcrumb if form is showed in Page
        $data['breadcrumb'][] = ['url' => agents_url('home/index'), 'title' => lang('home.dashboard')];

        if($formSlug === 'users')
        {
            $data['breadcrumb'][] = ['url' => agents_url('users/users'), 'title' => lang('users._page_users')];
            $data['breadcrumb'][] = ['title' => lang('users._form_users'), 'class' => 'active'];
        }
        else
        {
            log_message('error', "SECURITY: $formSlug form not founded");
            return $this->failNotFound("$formSlug not founded");
        }

        if (!empty($id))
        {
            $UsersModel = new UsersModel();
            
            $data['formData'] += $UsersModel->find($id) ?? [];
        }

        $copy      = (int) $this->request->getGet('copy');

        if (!empty($copy))
        {
            $UsersModel = new UsersModel();
            
            $data['formData'] += $UsersModel->find($copy);
            
            if(isset($data['formData']['user_id']))
            {
                unset($data['formData']['user_id']);
            }
        }

        

        $this->_render('form/' . $formSlug, $data);
    }

    //--------------------------------------------------------------------

    /**
     * Get UsertypeModel data
     * @return json
     */
    public function getAllUsertype() 
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

        $model = new UsertypeModel();
        $allowedFields = $model->getAllowedFields();
        
        if(!empty($q))
        {
            $model->groupStart();
            $model->orLike('usertype', $q);
            $model->groupEnd();
        }

        //-------------------------------------//
        /**
        * status field
        */
        $model->where('status', 1);
        //-------------------------------------//

        $model->where('deleted_at', NULL);

        $model->orderBy('usertype', 'asc');

        if (!empty($filterArray)) {
            foreach ($filterArray as $fieldName => $fieldValue) {

                if (in_array($fieldName, ['status', 'deleted_at', 'created_at', 'updated_at'])) 
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

    public function uploadFile($formSlug, $fieldName)
    {
        $formList = ['users'];

        if (!in_array($formSlug, $formList))
        {
            return $this->failNotFound("$formSlug not founded");
        }
            
        $fileService = \Agents\Config\Services::file();

        if($fieldName === 'avatar')
        {
            if (!$this->validate(['file' => ['label' => lang('users.avatar'), 'rules' => 'uploaded[file]|is_image[file]|max_size[file,1024]|ext_in[file,gif,jpg,jpeg,png]|max_dims[file,220,220]']]))
            {
                return $this->fail($this->validator->getErrors(), 400);
            }
            
            $return = $fileService->upload("users/$fieldName", true);
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
    
        $fileService = \Agents\Config\Services::file();

        $fileService->deleteFile((int) $file_id);

        return $this->respondDeleted(['id' => $file_id]);
    }

    //--------------------------------------------------------------------

    function updateFileOrder()
    {
        $order_ids = $this->request->getPost('order');        
        $fileService = \Agents\Config\Services::file();
        $fileService->updateFileOrders($order_ids);

        return $this->respond(['message' => lang('home.saved')]);
    }

    //--------------------------------------------------------------------
    /**
     * Update single field of users 
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
        $batchList = ['gender', 'status', 'deleted_at'];

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

        $model = new UsersModel();
        

        //validation
        if(isset($data['gender']))
        {
            if (!$this->validate([
                'gender' => ['label' => lang('users.gender'), 'rules' => 'required|in_list[male,female]|alpha_dash'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['status']))
        {
            if (!$this->validate([
                'status' => ['label' => lang('users.status'), 'rules' => 'required|integer|max_length[1]|in_list[1,2]'],
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

        //Page: users
        if($pageSlug === 'users' && $cardSlug === 'Total-Users')
        {
            $UsersModel = new UsersModel();
            $UsersModel->select('COUNT(user_id) as COUNT_user_id');

            //---------------------------------------------------------------------// 
            $UsersModel->where('users.status', '1');
            //---------------------------------------------------------------------//
            $UsersModel->where("deleted_at IS NULL");

            $cardData = $UsersModel->get()->getRowArray();
        }

        //Page: users
        elseif($pageSlug === 'users' && $cardSlug === 'Root-Users')
        {
            $UsersModel = new UsersModel();
            $UsersModel->select('COUNT(usertype) as COUNT_usertype');

            //---------------------------------------------------------------------// 
            $UsersModel->where('users.status', '1');
            //---------------------------------------------------------------------//
            $UsersModel->where("deleted_at IS NULL");
            $UsersModel->where("usertype=1");

            $cardData = $UsersModel->get()->getRowArray();
        }

        //Page: users
        elseif($pageSlug === 'users' && $cardSlug === 'Admin-Users')
        {
            $UsersModel = new UsersModel();
            $UsersModel->select('COUNT(usertype) as COUNT_usertype');

            //---------------------------------------------------------------------// 
            $UsersModel->where('users.status', '1');
            //---------------------------------------------------------------------//
            $UsersModel->where("deleted_at IS NULL");
            $UsersModel->where("usertype=2");

            $cardData = $UsersModel->get()->getRowArray();
        }

        //Page: users
        elseif($pageSlug === 'users' && $cardSlug === 'Polling-Agents')
        {
            $UsersModel = new UsersModel();
            $UsersModel->select('COUNT(usertype) as COUNT_usertype');

            //---------------------------------------------------------------------// 
            $UsersModel->where('users.status', '1');
            //---------------------------------------------------------------------//
            $UsersModel->where("deleted_at IS NULL");
            $UsersModel->where("usertype=3");

            $cardData = $UsersModel->get()->getRowArray();
        }

        return $this->response->setJSON($cardData);
    }
 
    //--------------------------------------------------------------------

    /**
     * Return module lang used in JS file.
     */
    public function langJS()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => 'b37e764']);

        $conf   = new \Config\App();
        $locale = $this->request->getLocale();

        //Load Home Lang File
        $langFile = ROOTPATH . 'agents/Language/' . $locale . '/users.php';

        if (!file_exists($langFile))
        {
            //Check default lang file
            $langFile = ROOTPATH . 'agents/Language/' . $conf->defaultLocale . '/users.php';

            if (!file_exists($langFile))
            {
                $langFile = null;
            }
        }

        $langArray['panel_language'] = $locale;
        $langArray['panel_url'] = agents_url(null, $locale); 

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
        echo 'var LANG_users = ' . json_encode($langArray, JSON_PRETTY_PRINT);
    }

    //--------------------------------------------------------------------

    private function _render($page, $data = [])
    {
        helper('form');

        $data['table_name']  = 'users';

        if ($this->request->isAJAX())
        {
            try
            {
                echo agents_view('users/' . $page, $data);
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
                echo agents_view('themes/' . $this->theme . '/header', $data);
                echo agents_view('users/' . $page, $data);
                echo agents_view('themes/' . $this->theme . '/footer', $data);
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