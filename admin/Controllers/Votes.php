<?php

namespace Admin\Controllers;

use CodeIgniter\API\ResponseTrait;
use Admin\Models\VotesModel;
use Admin\Models\C4_zoneModel;
use Admin\Models\CountyModel;
use Admin\Models\SubcountyModel;
use Admin\Models\ParishModel;
use Admin\Models\PollstatModel;
use Admin\Models\UsersModel;

class Votes extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------

    public function __construct()
    {
        helper(['Admin\votes', 'Admin\c4_zone', 'Admin\county', 'Admin\subcounty', 'Admin\parish', 'Admin\pollstat', 'Admin\users']);
    }

    //--------------------------------------------------------------------
    /**
     * view default page = votes 
     * votes   
     */
    public function index()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => 'd980ece']);

        $data                 = ['page_title' => lang('votes._page_votes')];
        $data['breadcrumb'][] = ['url' => admin_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('votes._page_votes'), 'class' => 'active'];

        $this->_render('votes', $data);
    }
    //--------------------------------------------------------------------
    /**
     * view page = votes
     * Votes  
     */
    public function votes()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '187d475']);

        $data                 = ['page_title' => lang('votes._page_votes')];
        $data['breadcrumb'][] = ['url' => admin_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('votes._page_votes'), 'class' => 'active'];

        $this->_render('votes', $data);
    }

    //--------------------------------------------------------------------
    /**
     * create or update
     * @return json
     */
    public function save($form_slug, $id = '')
    {
        $data       = $this->request->getPost();
        $validation = \Config\Services::validation();

        //---------------------------------------------------------------------//
        //For form_slug=votes pageSlug=votes
        if($form_slug === 'votes')
        {

            // votes form Validations and security
            $validation->setRules([
                'districtid'    => ['label' => lang('votes.districtid'), 'rules'=>"required|integer|max_length[11]"],
                'countyid'      => ['label' => lang('votes.countyid'), 'rules'=>"required|integer|max_length[11]"],
                'subcountyid'   => ['label' => lang('votes.subcountyid'), 'rules'=>"required|integer|max_length[11]"],
                'parishid'      => ['label' => lang('votes.parishid'), 'rules'=>"required|integer|max_length[11]|is_unique[votes.parishid,id,{$_POST['id']}]"],
                'pollstatid'    => ['label' => lang('votes.pollstatid'), 'rules'=>"required|integer|max_length[11]"],
                'candidate1'    => ['label' => lang('votes.candidate1'), 'rules'=>"required|integer|max_length[11]"],
                'candidate2'    => ['label' => lang('votes.candidate2'), 'rules'=>"required|integer|max_length[11]"],
                'candidate3'    => ['label' => lang('votes.candidate3'), 'rules'=>"required|integer|max_length[11]"],
                'candidate4'    => ['label' => lang('votes.candidate4'), 'rules'=>"required|integer|max_length[11]"],
                'validvotes'    => ['label' => lang('votes.validvotes'), 'rules'=>"required|integer|max_length[11]"],
                'invalidvotes'  => ['label' => lang('votes.invalidvotes'), 'rules'=>"required|integer|max_length[11]"],
                'totalvoters'   => ['label' => lang('votes.totalvoters'), 'rules'=>"required|integer|max_length[11]"],
                'notvoted'      => ['label' => lang('votes.notvoted'), 'rules'=>"required|integer|max_length[11]"],
                'totalballotiss' => ['label' => lang('votes.totalballotiss'), 'rules'=>"required|integer|max_length[11]"],
                'totalballotuse' => ['label' => lang('votes.totalballotuse'), 'rules'=>"required|integer|max_length[11]"],
                'evidence'      => ['label' => lang('votes.evidence'), 'rules'=>"required|integer|max_length[20]"],
                'userid'        => ['label' => lang('votes.userid'), 'rules'=>"required|integer|max_length[11]"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['districtid', 'countyid', 'subcountyid', 'parishid', 'pollstatid', 'candidate1', 'candidate2', 'candidate3', 'candidate4', 'validvotes', 'invalidvotes', 'totalvoters', 'notvoted', 'totalballotiss', 'totalballotuse', 'evidence', 'userid', 'id'];
            $data             = array_intersect_key($data, array_flip($filterFormFields));
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check districtid for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_districtid'))  && empty(getC4_zone($data['districtid'])))
            {
                log_message('error', 'SECURITY: Undefined districtid value posted');
                return $this->fail(['districtid'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check countyid for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_countyid'))  && empty(getCounty($data['countyid'])))
            {
                log_message('error', 'SECURITY: Undefined countyid value posted');
                return $this->fail(['countyid'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check subcountyid for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_subcountyid'))  && empty(getSubcounty($data['subcountyid'])))
            {
                log_message('error', 'SECURITY: Undefined subcountyid value posted');
                return $this->fail(['subcountyid'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check parishid for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_parishid'))  && empty(getParish($data['parishid'])))
            {
                log_message('error', 'SECURITY: Undefined parishid value posted');
                return $this->fail(['parishid'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check pollstatid for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_pollstatid'))  && empty(getPollstat($data['pollstatid'])))
            {
                log_message('error', 'SECURITY: Undefined pollstatid value posted');
                return $this->fail(['pollstatid'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check userid for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_userid'))  && empty(getUsers($data['userid'])))
            {
                log_message('error', 'SECURITY: Undefined userid value posted');
                return $this->fail(['userid'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
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

        $VotesModel = new VotesModel();

        try
        {
            $VotesModel->save($data);
        }
        catch (\Exception $e)
        {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->fail($e->getMessage(), 400, lang('home.error_validation_form'));
        }
        
        if(empty($id))
        {
            $id = $VotesModel->getInsertID();
        }

        return $this->respondCreated(['id' => $id, 'message' => lang('home.saved')]);
    }
 
    //--------------------------------------------------------------------

    /**
     * Read votes data
     * Functions adds DT_RowId variable to each row for datatables.net
     * 
     * Search Contions may change according to $pageSlug
     * 
     * @param string $pageSlug
     * @return array
     * 
     */
    public function readVotes($pageSlug)
    {

        $pageList = ['votes'];
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

        $model      = new VotesModel();
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
        // Page votes
        //--------------------------------------------------------------------//

        if($pageSlug === 'votes')
        {
            $select_text       = "votes.*, c4_zone.name as c4_zone_RELATIONAL_name, county.name as county_RELATIONAL_name, subcounty.name as subcounty_RELATIONAL_name, parish.name as parish_RELATIONAL_name, pollstat.name as pollstat_RELATIONAL_name, users.firstname as users_RELATIONAL_firstname";
            $multipleFields    = [];

            //------------------------------------------------------------------//
            //merge relation fields names to make Sortable
            $table_colons = array_merge($table_colons, ['c4_zone_RELATIONAL_name', 'county_RELATIONAL_name', 'subcounty_RELATIONAL_name', 'parish_RELATIONAL_name', 'pollstat_RELATIONAL_name', 'users_RELATIONAL_firstname']);
            //------------------------------------------------------------------//
            //------------------------------------------------------------------//        
            // Left Join Text
            //------------------------------------------------------------------//
            $model->join("(SELECT c4_zone_id, name FROM c4_zone GROUP BY c4_zone_id ORDER BY c4_zone_id DESC) c4_zone", 'c4_zone.c4_zone_id = votes.districtid', 'left');
            $model->join("(SELECT countyid, name FROM county WHERE county.deleted_at IS NULL AND county.status = '1' GROUP BY countyid ORDER BY countyid DESC) county", 'county.countyid = votes.countyid', 'left');
            $model->join("(SELECT id, name FROM subcounty WHERE subcounty.deleted_at IS NULL AND subcounty.status = '1' GROUP BY id ORDER BY id DESC) subcounty", 'subcounty.id = votes.subcountyid', 'left');
            $model->join("(SELECT id, name FROM parish WHERE parish.deleted_at IS NULL AND parish.status = '1' GROUP BY id ORDER BY id DESC) parish", 'parish.id = votes.parishid', 'left');
            $model->join("(SELECT id, name FROM pollstat WHERE pollstat.deleted_at IS NULL AND pollstat.status = '1' GROUP BY id ORDER BY id DESC) pollstat", 'pollstat.id = votes.pollstatid', 'left');
            $model->join("(SELECT user_id, firstname FROM users WHERE users.deleted_at IS NULL AND users.status = '1' GROUP BY user_id ORDER BY user_id DESC) users", 'users.user_id = votes.userid', 'left');

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
                    $model->where("votes.$filterField", trim(filter_var($filterValue, FILTER_SANITIZE_STRING)));
                }
            }
        }
        //Show Allways active status if not filtered
        if (!isset($filterArray['status']))
        {
            $model->where('votes.status', '1');
        }
        else
        {
            $model->where('votes.status', $filterArray['status']);
        }
        if (isset($filterArray['deleted_at']) && $filterArray['deleted_at'] === '1')
        {
            $model->onlyDeleted();
        }
        else
        {
            $model->where('votes.deleted_at', NULL);
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
                    $model->where("votes.$key_field >=", $fieldValue);
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
                    $model->where("votes.$key_field <=", $fieldValue .' 23:59:59');
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
                // Page votes
                //--------------------------------------------------------------------//

                if($pageSlug === 'votes')
                { 

                    //------------------------------------------------------------------//
                    // Get File Data From FileID
                    // Limit 1
                    //------------------------------------------------------------------//
                    $fileService = \Admin\Config\Services::file();

                    if(!empty($value->evidence) && !empty($getFiles = $fileService->getAllFile($value->evidence, 1, 'sort_order')))
                    {
                        $db_result[$key]->evidence_c4_url_icon = $getFiles[0]['url_icon'];
                        $db_result[$key]->evidence_c4_url_thumb = $getFiles[0]['url_thumb'];
                        $db_result[$key]->evidence_c4_url_download = $getFiles[0]['url_download'];
                        $db_result[$key]->evidence_c4_other = $getFiles;
                    }
                    else
                    {
                        $db_result[$key]->evidence = '';
                        $db_result[$key]->evidence_fileInfo = []; 
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

    //--------------------------------------------------------------------

    /**
     * Show form by formSlug
     * @param string $formSlug
     * @return html
     */
    public function showForm($formSlug, $id = null)
    {
        $formSlug = trim($formSlug);

        $data['page_title'] = lang('votes._form_' .$formSlug);
        $data['formData'] = $_POST;
        
        // -----------------------------------
        //breadcrumb if form is showed in Page
        $data['breadcrumb'][] = ['url' => admin_url('home/index'), 'title' => lang('home.dashboard')];

        if($formSlug === 'votes')
        {
            $data['breadcrumb'][] = ['url' => admin_url('votes/votes'), 'title' => lang('votes._page_votes')];
            $data['breadcrumb'][] = ['title' => lang('votes._form_votes'), 'class' => 'active'];
        }
        else
        {
            log_message('error', "SECURITY: $formSlug form not founded");
            return $this->failNotFound("$formSlug not founded");
        }

        if (!empty($id))
        {
            $VotesModel = new VotesModel();
            
            $data['formData'] += $VotesModel->find($id) ?? [];
        }

        $copy      = (int) $this->request->getGet('copy');

        if (!empty($copy))
        {
            $VotesModel = new VotesModel();
            
            $data['formData'] += $VotesModel->find($copy);
            
            if(isset($data['formData']['id']))
            {
                unset($data['formData']['id']);
            }
        }

        

        $this->_render('form/' . $formSlug, $data);
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

        $model = new C4_zoneModel();
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

    /**
     * Get CountyModel data
     * @return json
     */
    public function getAllCounty() 
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

        $model = new CountyModel();
        $allowedFields = $model->getAllowedFields();
        
        if(!empty($q))
        {
            $model->groupStart();
            $model->orLike('name', $q);
            $model->groupEnd();
        }

        //-------------------------------------//
        /**
        * status field
        */
        $model->where('status', 1);
        //-------------------------------------//

        $model->where('deleted_at', NULL);

        $model->orderBy('name', 'asc');

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

    /**
     * Get SubcountyModel data
     * @return json
     */
    public function getAllSubcounty() 
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

        $model = new SubcountyModel();
        $allowedFields = $model->getAllowedFields();
        
        if(!empty($q))
        {
            $model->groupStart();
            $model->orLike('name', $q);
            $model->groupEnd();
        }

        //-------------------------------------//
        /**
        * status field
        */
        $model->where('status', 1);
        //-------------------------------------//

        $model->where('deleted_at', NULL);

        $model->orderBy('name', 'asc');

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

    /**
     * Get ParishModel data
     * @return json
     */
    public function getAllParish() 
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

        $model = new ParishModel();
        $allowedFields = $model->getAllowedFields();
        
        if(!empty($q))
        {
            $model->groupStart();
            $model->orLike('name', $q);
            $model->groupEnd();
        }

        //-------------------------------------//
        /**
        * status field
        */
        $model->where('status', 1);
        //-------------------------------------//

        $model->where('deleted_at', NULL);

        $model->orderBy('name', 'asc');

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

    /**
     * Get PollstatModel data
     * @return json
     */
    public function getAllPollstat() 
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

        $model = new PollstatModel();
        $allowedFields = $model->getAllowedFields();
        
        if(!empty($q))
        {
            $model->groupStart();
            $model->orLike('name', $q);
            $model->groupEnd();
        }

        //-------------------------------------//
        /**
        * status field
        */
        $model->where('status', 1);
        //-------------------------------------//

        $model->where('deleted_at', NULL);

        $model->orderBy('name', 'asc');

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

    /**
     * Get UsersModel data
     * @return json
     */
    public function getAllUsers() 
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

        $model = new UsersModel();
        $allowedFields = $model->getAllowedFields();
        
        if(!empty($q))
        {
            $model->groupStart();
            $model->orLike('firstname', $q);
            $model->groupEnd();
        }

        //-------------------------------------//
        /**
        * status field
        */
        $model->where('status', 1);
        //-------------------------------------//

        $model->where('deleted_at', NULL);

        $model->orderBy('firstname', 'asc');

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
        $formList = ['votes'];

        if (!in_array($formSlug, $formList))
        {
            return $this->failNotFound("$formSlug not founded");
        }
            
        $fileService = \Admin\Config\Services::file();

        if($fieldName === 'evidence')
        {
            if (!$this->validate(['file' => ['label' => lang('votes.evidence'), 'rules' => 'uploaded[file]|is_image[file]|max_size[file,2048]|ext_in[file,gif,jpg,jpeg,png]|max_dims[file,2048,2048]']]))
            {
                return $this->fail($this->validator->getErrors(), 400);
            }
            
            $return = $fileService->upload("votes/$fieldName", true);
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
     * Update single field of votes 
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

        $model = new VotesModel();
        

        //validation
        if(isset($data['status']))
        {
            if (!$this->validate([
                'status' => ['label' => lang('votes.status'), 'rules' => 'required|integer|max_length[1]|in_list[1,2]'],
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

        //Page: votes
        if($pageSlug === 'votes' && $cardSlug === 'Olemukan-Moses')
        {
            $VotesModel = new VotesModel();
            $VotesModel->select('IFNULL(SUM(candidate1), 0) as SUM_candidate1');

            //---------------------------------------------------------------------// 
            $VotesModel->where('votes.status', '1');
            //---------------------------------------------------------------------//
            $VotesModel->where("deleted_at IS NULL");

            $cardData = $VotesModel->get()->getRowArray();
        }

        //Page: votes
        elseif($pageSlug === 'votes' && $cardSlug === 'Tukei-William-Wilberforce')
        {
            $VotesModel = new VotesModel();
            $VotesModel->select('IFNULL(SUM(candidate2), 0) as SUM_candidate2');

            //---------------------------------------------------------------------// 
            $VotesModel->where('votes.status', '1');
            //---------------------------------------------------------------------//
            $VotesModel->where("deleted_at IS NULL");

            $cardData = $VotesModel->get()->getRowArray();
        }

        //Page: votes
        elseif($pageSlug === 'votes' && $cardSlug === 'Osekeny-Sam')
        {
            $VotesModel = new VotesModel();
            $VotesModel->select('IFNULL(SUM(candidate3), 0) as SUM_candidate3');

            //---------------------------------------------------------------------// 
            $VotesModel->where('votes.status', '1');
            //---------------------------------------------------------------------//
            $VotesModel->where("deleted_at IS NULL");

            $cardData = $VotesModel->get()->getRowArray();
        }

        //Page: votes
        elseif($pageSlug === 'votes' && $cardSlug === 'Omagor-Sam-Okoche')
        {
            $VotesModel = new VotesModel();
            $VotesModel->select('IFNULL(SUM(candidate4), 0) as SUM_candidate4');

            //---------------------------------------------------------------------// 
            $VotesModel->where('votes.status', '1');
            //---------------------------------------------------------------------//
            $VotesModel->where("deleted_at IS NULL");

            $cardData = $VotesModel->get()->getRowArray();
        }

        //Page: votes
        elseif($pageSlug === 'votes' && $cardSlug === 'Total-Invalid')
        {
            $VotesModel = new VotesModel();
            $VotesModel->select('IFNULL(SUM(invalidvotes), 0) as SUM_invalidvotes');

            //---------------------------------------------------------------------// 
            $VotesModel->where('votes.status', '1');
            //---------------------------------------------------------------------//
            $VotesModel->where("deleted_at IS NULL");

            $cardData = $VotesModel->get()->getRowArray();
        }

        //Page: votes
        elseif($pageSlug === 'votes' && $cardSlug === 'Total-Not-Voted')
        {
            $VotesModel = new VotesModel();
            $VotesModel->select('IFNULL(SUM(notvoted), 0) as SUM_notvoted');

            //---------------------------------------------------------------------// 
            $VotesModel->where('votes.status', '1');
            //---------------------------------------------------------------------//
            $VotesModel->where("deleted_at IS NULL");

            $cardData = $VotesModel->get()->getRowArray();
        }

        //Page: votes
        elseif($pageSlug === 'votes' && $cardSlug === 'Polling-Stations-Recorded')
        {
            $VotesModel = new VotesModel();
            $VotesModel->select('COUNT(pollstatid) as COUNT_pollstatid');

            //---------------------------------------------------------------------// 
            $VotesModel->where('votes.status', '1');
            //---------------------------------------------------------------------//
            $VotesModel->where("deleted_at IS NULL");

            $cardData = $VotesModel->get()->getRowArray();
        }

        //Page: votes
        elseif($pageSlug === 'votes' && $cardSlug === 'Total-Voters')
        {
            $VotesModel = new VotesModel();
            $VotesModel->select('IFNULL(SUM(totalvoters), 0) as SUM_totalvoters');

            //---------------------------------------------------------------------// 
            $VotesModel->where('votes.status', '1');
            //---------------------------------------------------------------------//
            $VotesModel->where("deleted_at IS NULL");

            $cardData = $VotesModel->get()->getRowArray();
        }

        //Page: votes
        elseif($pageSlug === 'votes' && $cardSlug === 'Total-Ballots-Issued')
        {
            $VotesModel = new VotesModel();
            $VotesModel->select('IFNULL(SUM(totalballotiss), 0) as SUM_totalballotiss');

            //---------------------------------------------------------------------// 
            $VotesModel->where('votes.status', '1');
            //---------------------------------------------------------------------//
            $VotesModel->where("deleted_at IS NULL");

            $cardData = $VotesModel->get()->getRowArray();
        }

        //Page: votes
        elseif($pageSlug === 'votes' && $cardSlug === 'Total-Ballots-Used')
        {
            $VotesModel = new VotesModel();
            $VotesModel->select('IFNULL(SUM(totalballotuse), 0) as SUM_totalballotuse');

            //---------------------------------------------------------------------// 
            $VotesModel->where('votes.status', '1');
            //---------------------------------------------------------------------//
            $VotesModel->where("deleted_at IS NULL");

            $cardData = $VotesModel->get()->getRowArray();
        }

        return $this->response->setJSON($cardData);
    }
 
    //--------------------------------------------------------------------

    /**
     * Return module lang used in JS file.
     */
    public function langJS()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => 'b57325e']);

        $conf   = new \Config\App();
        $locale = $this->request->getLocale();

        //Load Home Lang File
        $langFile = ROOTPATH . 'admin/Language/' . $locale . '/votes.php';

        if (!file_exists($langFile))
        {
            //Check default lang file
            $langFile = ROOTPATH . 'admin/Language/' . $conf->defaultLocale . '/votes.php';

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
        echo 'var LANG_votes = ' . json_encode($langArray, JSON_PRETTY_PRINT);
    }

    //--------------------------------------------------------------------

    private function _render($page, $data = [])
    {
        helper('form');

        $data['table_name']  = 'votes';

        if ($this->request->isAJAX())
        {
            try
            {
                echo admin_view('votes/' . $page, $data);
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
                echo admin_view('votes/' . $page, $data);
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