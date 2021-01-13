<?php

namespace Agents\Controllers;

use CodeIgniter\API\ResponseTrait;
use Agents\Models\PolllistModel;
use Agents\Models\C4_zoneModel;
use Agents\Models\CountyModel;
use Agents\Models\SubcountyModel;
use Agents\Models\ParishModel;
use Agents\Models\PollstatModel;

class Polllist extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------

    public function __construct()
    {
        helper(['Agents\polllist', 'Agents\c4_zone', 'Agents\county', 'Agents\subcounty', 'Agents\parish', 'Agents\pollstat']);
    }

    //--------------------------------------------------------------------
    /**
     * view default page = polllist 
     * polllist   
     */
    public function index()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => 'f753966']);

        $data                 = ['page_title' => lang('polllist._page_polllist')];
        $data['breadcrumb'][] = ['url' => agents_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('polllist._page_polllist'), 'class' => 'active'];

        $this->_render('polllist', $data);
    }
    //--------------------------------------------------------------------
    /**
     * view page = polllist
     * Polling Stations  
     */
    public function polllist()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '165287e']);

        $data                 = ['page_title' => lang('polllist._page_polllist')];
        $data['breadcrumb'][] = ['url' => agents_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('polllist._page_polllist'), 'class' => 'active'];

        $this->_render('polllist', $data);
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
        //For form_slug=polllist pageSlug=polllist
        if($form_slug === 'polllist')
        {

            // polllist form Validations and security
            $validation->setRules([
                'districtid'    => ['label' => lang('polllist.districtid'), 'rules'=>"required|integer|max_length[11]"],
                'countyid'      => ['label' => lang('polllist.countyid'), 'rules'=>"required|integer|max_length[11]"],
                'subcountyid'   => ['label' => lang('polllist.subcountyid'), 'rules'=>"required|integer|max_length[11]"],
                'parishid'      => ['label' => lang('polllist.parishid'), 'rules'=>"required|integer|max_length[11]"],
                'pollstatid'    => ['label' => lang('polllist.pollstatid'), 'rules'=>"required|integer|max_length[11]"],
                'comment'       => ['label' => lang('polllist.comment'), 'rules'=>"permit_empty|string"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['districtid', 'countyid', 'subcountyid', 'parishid', 'pollstatid', 'comment', 'id'];
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

        }
        //---------------------------------------------------------------------//
        else
        {
            //not matched
            log_message('error', "SECURITY: $form_slug form not founded");
            return $this->failNotFound("$form_slug form not found");
        }

        $PolllistModel = new PolllistModel();

        try
        {
            $PolllistModel->save($data);
        }
        catch (\Exception $e)
        {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->fail($e->getMessage(), 400, lang('home.error_validation_form'));
        }
        
        if(empty($id))
        {
            $id = $PolllistModel->getInsertID();
        }

        return $this->respondCreated(['id' => $id, 'message' => lang('home.saved')]);
    }
 
    //--------------------------------------------------------------------

    /**
     * Read polllist data
     * Functions adds DT_RowId variable to each row for datatables.net
     * 
     * Search Contions may change according to $pageSlug
     * 
     * @param string $pageSlug
     * @return array
     * 
     */
    public function readPolllist($pageSlug)
    {

        $pageList = ['polllist'];
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

        $model      = new PolllistModel();
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
        // Page polllist
        //--------------------------------------------------------------------//

        if($pageSlug === 'polllist')
        {
            $select_text       = "polllist.*, pollstat.name as pollstat_RELATIONAL_name, parish.name as parish_RELATIONAL_name, subcounty.name as subcounty_RELATIONAL_name, county.name as county_RELATIONAL_name, c4_zone.name as c4_zone_RELATIONAL_name";
            $multipleFields    = [];

            //------------------------------------------------------------------//
            //merge relation fields names to make Sortable
            $table_colons = array_merge($table_colons, ['pollstat_RELATIONAL_name', 'parish_RELATIONAL_name', 'subcounty_RELATIONAL_name', 'county_RELATIONAL_name', 'c4_zone_RELATIONAL_name']);
            //------------------------------------------------------------------//
            //------------------------------------------------------------------//        
            // Left Join Text
            //------------------------------------------------------------------//
            $model->join("(SELECT id, name FROM pollstat WHERE pollstat.deleted_at IS NULL AND pollstat.status = '1' GROUP BY id ORDER BY id DESC) pollstat", 'pollstat.id = polllist.pollstatid', 'left');
            $model->join("(SELECT id, name FROM parish WHERE parish.deleted_at IS NULL AND parish.status = '1' GROUP BY id ORDER BY id DESC) parish", 'parish.id = polllist.parishid', 'left');
            $model->join("(SELECT id, name FROM subcounty WHERE subcounty.deleted_at IS NULL AND subcounty.status = '1' GROUP BY id ORDER BY id DESC) subcounty", 'subcounty.id = polllist.subcountyid', 'left');
            $model->join("(SELECT countyid, name FROM county WHERE county.deleted_at IS NULL AND county.status = '1' GROUP BY countyid ORDER BY countyid DESC) county", 'county.countyid = polllist.countyid', 'left');
            $model->join("(SELECT c4_zone_id, name FROM c4_zone GROUP BY c4_zone_id ORDER BY c4_zone_id DESC) c4_zone", 'c4_zone.c4_zone_id = polllist.districtid', 'left');

            if (!empty($search_text))
            {
                $search_text = filter_var($search_text, FILTER_SANITIZE_STRING);
                $model->groupStart();
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
                    $model->where("polllist.$filterField", trim(filter_var($filterValue, FILTER_SANITIZE_STRING)));
                }
            }
        }
        //Show Allways active status if not filtered
        if (!isset($filterArray['status']))
        {
            $model->where('polllist.status', '1');
        }
        else
        {
            $model->where('polllist.status', $filterArray['status']);
        }
        if (isset($filterArray['deleted_at']) && $filterArray['deleted_at'] === '1')
        {
            $model->onlyDeleted();
        }
        else
        {
            $model->where('polllist.deleted_at', NULL);
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
                    $model->where("polllist.$key_field >=", $fieldValue);
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
                    $model->where("polllist.$key_field <=", $fieldValue .' 23:59:59');
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
                // Page polllist
                //--------------------------------------------------------------------//

                if($pageSlug === 'polllist')
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
     * Delete polllist by id
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

        $PolllistModel = new PolllistModel();
        if ($PolllistModel->delete($id, true) === false)
        {
            log_message('error', "Error: $id ID PolllistModel Delete Error");
            return $this->fail($PolllistModel->errors());
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

        $data['page_title'] = lang('polllist._form_' .$formSlug);
        $data['formData'] = $_POST;
        
        // -----------------------------------
        //breadcrumb if form is showed in Page
        $data['breadcrumb'][] = ['url' => agents_url('home/index'), 'title' => lang('home.dashboard')];

        if($formSlug === 'polllist')
        {
            $data['breadcrumb'][] = ['url' => agents_url('polllist/polllist'), 'title' => lang('polllist._page_polllist')];
            $data['breadcrumb'][] = ['title' => lang('polllist._form_polllist'), 'class' => 'active'];
        }
        else
        {
            log_message('error', "SECURITY: $formSlug form not founded");
            return $this->failNotFound("$formSlug not founded");
        }

        if (!empty($id))
        {
            $PolllistModel = new PolllistModel();
            
            $data['formData'] += $PolllistModel->find($id) ?? [];
        }

        $copy      = (int) $this->request->getGet('copy');

        if (!empty($copy))
        {
            $PolllistModel = new PolllistModel();
            
            $data['formData'] += $PolllistModel->find($copy);
            
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
     * Update single field of polllist 
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

        $model = new PolllistModel();
        

        //validation
        if(isset($data['status']))
        {
            if (!$this->validate([
                'status' => ['label' => lang('polllist.status'), 'rules' => 'required|integer|max_length[1]|in_list[1,2]'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['deleted_at']))
        {
            if($data['deleted_at'] === '1')
            {
                $model->delete($id, true);
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
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => 'f49eceb']);

        $conf   = new \Config\App();
        $locale = $this->request->getLocale();

        //Load Home Lang File
        $langFile = ROOTPATH . 'agents/Language/' . $locale . '/polllist.php';

        if (!file_exists($langFile))
        {
            //Check default lang file
            $langFile = ROOTPATH . 'agents/Language/' . $conf->defaultLocale . '/polllist.php';

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
        echo 'var LANG_polllist = ' . json_encode($langArray, JSON_PRETTY_PRINT);
    }

    //--------------------------------------------------------------------

    private function _render($page, $data = [])
    {
        helper('form');

        $data['table_name']  = 'polllist';

        if ($this->request->isAJAX())
        {
            try
            {
                echo agents_view('polllist/' . $page, $data);
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
                echo agents_view('polllist/' . $page, $data);
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