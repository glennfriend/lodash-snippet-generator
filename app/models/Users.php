<?php

/**
 *
 */
class Users extends ZendModel
{
    const CACHE_USER        = 'cache_user';
    const CACHE_USER_EMAIL  = 'cache_user_email';

    /**
     *  table name
     */
    protected $tableName = 'users';

    /**
     *  get method
     */
    protected $getMethod = 'getUser';

    /**
     *  get db object by record
     *  @param  row
     *  @return TahScan object
     */
    public function mapRow( $row )
    {
        $object = new User();
        $object->setId                   ( $row['id']                      );
        $object->setUniqueCode           ( $row['unique_code']             );
        $object->setProfileUrl           ( $row['profile_url']             );
        $object->setEmail                ( $row['email']                   );
        $object->setPassword             ( $row['password']                );
        $object->setRole                 ( $row['role']                    );
        $object->setUrl                  ( $row['url']                     );
        $object->setRememberToken        ( $row['remember_token']          );
        $object->setCreatedOn            ( strtotime($row['created_on'])   );
        $object->setUpdatedOn            ( strtotime($row['updated_on'])   );
        $object->setRandstr              ( $row['randstr']                 );
        $object->setSbGp                 ( $row['sb_gp']                   );
        $object->setIntro                ( $row['intro']                   );
        $object->setPublisher            ( $row['publisher']               );
        return $object;
    }

    /* ================================================================================
        write database
    ================================================================================ */

    /**
     *  add User
     *  @param User object
     *  @return insert id or false
     */
    public function addUser($object)
    {
        $insertId = $this->addObject($object, true);
        if (!$insertId) {
            return false;
        }

        $object = $this->getUser($insertId);
        if (!$object) {
            return false;
        }

        $this->preChangeHook($object);
        return $insertId;
    }

    /**
     *  update User
     *  @param User object
     *  @return int
     */
    public function updateUser($object)
    {
        $result = $this->updateObject($object);
        if (!$result) {
            return false;
        }

        $this->preChangeHook($object);
        return $result;
    }

    /**
     *  pre change hook, first remove cache, second do something more
     *  about add, update, delete
     *  @param object
     */
    public function preChangeHook($object)
    {
        // first, remove cache
        $this->removeCache($object);
    }

    /**
     *  remove cache
     *  @param object
     */
    protected function removeCache($object)
    {
        if ( $object->getId() <= 0 ) {
            return;
        }

        $cacheKey = $this->getFullCacheKey( $object->getId(), Users::CACHE_USER );
        CacheBrg::remove( $cacheKey );

        $cacheKey = $this->getFullCacheKey( $object->getEmail(), Users::CACHE_USER_EMAIL );
        CacheBrg::remove( $cacheKey );
    }


    /* ================================================================================
        read access database
    ================================================================================ */

    /**
     *  get User by id
     *  @param  int id
     *  @return object or false
     */
    public function getUser($id)
    {
        $object = $this->getObject('id', $id, Users::CACHE_USER );
        if ( !$object ) {
            return false;
        }
        return $object;
    }

    /**
     *  get User by id
     *  @param  int id
     *  @return object or false
     */
    public function getUserByEmail($email)
    {
        $object = $this->getObject('email', $email, Users::CACHE_USER_EMAIL );
        if ( !$object ) {
            return false;
        }
        return $object;
    }

    /* ================================================================================
        find Users and get count
        多欄、針對性的搜尋, 主要在後台方便使用, 使用 and 搜尋方式
    ================================================================================ */

    /**
     *  find many User
     *  @param  option array
     *  @return objects or empty array
     */
    public function findUsers($opt=[])
    {
        $opt += [
            '_order'               => 'id,DESC',
            '_page'                => 1,
            '_itemsPerPage'        => Config::get('db.items_per_page')
        ];
        return $this->findUsersReal( $opt );
    }

    /**
     *  get count by "findUsers" method
     *  @return int
     */
    public function numFindUsers($opt=[])
    {
        // $opt += [];
        return $this->findUsersReal($opt, true);
    }

    /**
     *  findUsers option
     *  @return objects or record total
     */
    protected function findUsersReal($opt=[], $isGetCount=false)
    {
        // validate 欄位 白名單
        $list = [
            'fields' => [
                'id'                    => 'id',
                'uniqueCode'            => 'unique_code',
                'profileUrl'            => 'profile_url',
                'email'                 => 'email',
                'password'              => 'password',
                'role'                  => 'role',
                'url'                   => 'url',
                'rememberToken'         => 'remember_token',
                'createdOn'             => 'created_on',
                'updatedOn'             => 'updated_on',
                'randstr'               => 'randstr',
                'sbGp'                  => 'sb_gp',
                'intro'                 => 'intro',
                'publisher'             => 'publisher',
            ],
            'option' => [
                '_order',
                '_page',
                '_itemsPerPage',
            ]
        ];

        ZendModelWhiteListHelper::validateFields($opt, $list);
        ZendModelWhiteListHelper::filterOrder($opt, $list);
        ZendModelWhiteListHelper::fieldValueNullToEmpty($opt);

        $select = $this->getDbSelect();

        //
        $field = $list['fields'];

        if ( isset($opt['id']) ) {
            $select->where->and->equalTo( $field['id'], $opt['id'] );
        }
        if ( isset($opt['uniqueCode']) ) {
            $select->where->and->equalTo( $field['uniqueCode'], $opt['uniqueCode'] );
        }
        if ( isset($opt['profileUrl']) ) {
            $select->where->and->equalTo( $field['profileUrl'], $opt['profileUrl'] );
        }
        if ( isset($opt['email']) ) {
            $select->where->and->equalTo( $field['email'], $opt['email'] );
        }
        if ( isset($opt['password']) ) {
            $select->where->and->equalTo( $field['password'], $opt['password'] );
        }
        if ( isset($opt['role']) ) {
            $select->where->and->equalTo( $field['role'], $opt['role'] );
        }
        if ( isset($opt['url']) ) {
            $select->where->and->equalTo( $field['url'], $opt['url'] );
        }
        if ( isset($opt['rememberToken']) ) {
            $select->where->and->equalTo( $field['rememberToken'], $opt['rememberToken'] );
        }
        if ( isset($opt['randstr']) ) {
            $select->where->and->like( $field['randstr'], '%'.$opt['randstr'].'%' );
        }
        if ( isset($opt['sbGp']) ) {
            $select->where->and->equalTo( $field['sbGp'], $opt['sbGp'] );
        }
        if ( isset($opt['intro']) ) {
            $select->where->and->equalTo( $field['intro'], $opt['intro'] );
        }
        if ( isset($opt['publisher']) ) {
            $select->where->and->equalTo( $field['publisher'], $opt['publisher'] );
        }

        if ( !$isGetCount ) {
            return $this->findObjects( $select, $opt );
        }
        return $this->numFindObjects( $select );
    }


}
