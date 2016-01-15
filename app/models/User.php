<?php

/**
 *  User
 *
 */
class User extends BaseObject
{

    /**
     *  請依照 table 正確填寫該 field 內容
     *  @return array()
     */
    public static function getTableDefinition()
    {
        return [
            'id' => [
                'type'    => 'integer',
                'filters' => ['intval'],
                'storage' => 'getId',
                'field'   => 'id',
            ],
            'uniqueCode' => [
                'type'    => 'string',
                'filters' => ['strip_tags','trim'],
                'storage' => 'getUniqueCode',
                'field'   => 'unique_code',
            ],
            'profileUrl' => [
                'type'    => 'string',
                'filters' => ['strip_tags','trim'],
                'storage' => 'getProfileUrl',
                'field'   => 'profile_url',
            ],
            'email' => [
                'type'    => 'string',
                'filters' => ['strip_tags','trim'],
                'storage' => 'getEmail',
                'field'   => 'email',
            ],
            'password' => [
                'type'    => 'string',
                'filters' => ['strip_tags','trim'],
                'storage' => 'getPassword',
                'field'   => 'password',
            ],
            'role' => [
                'type'    => 'string',
                'filters' => ['strip_tags','trim'],
                'storage' => 'getRole',
                'field'   => 'role',
            ],
            'url' => [
                'type'    => 'string',
                'filters' => ['strip_tags','trim'],
                'storage' => 'getUrl',
                'field'   => 'url',
            ],
            'rememberToken' => [
                'type'    => 'string',
                'filters' => ['strip_tags','trim'],
                'storage' => 'getRememberToken',
                'field'   => 'remember_token',
            ],
            'createdOn' => [
                'type'    => 'timestamp',
                'filters' => ['dateval'],
                'storage' => 'getCreatedOn',
                'field'   => 'created_on',
                'value'   => time(),
            ],
            'updatedOn' => [
                'type'    => 'timestamp',
                'filters' => ['dateval'],
                'storage' => 'getUpdatedOn',
                'field'   => 'updated_on',
                'value'   => time(),
            ],
            'randstr' => [
                'type'    => 'string',
                'filters' => ['strip_tags','trim'],
                'storage' => 'getRandstr',
                'field'   => 'randstr',
            ],
            'sbGp' => [
                'type'    => 'integer',
                'filters' => ['intval'],
                'storage' => 'getSbGp',
                'field'   => 'sb_gp',
            ],
            'intro' => [
                'type'    => 'integer',
                'filters' => ['intval'],
                'storage' => 'getIntro',
                'field'   => 'intro',
            ],
            'publisher' => [
                'type'    => 'string',
                'filters' => ['strip_tags','trim'],
                'storage' => 'getPublisher',
                'field'   => 'publisher',
            ],
        ];
    }

    // /**
    //  *  reset value
    //  */
    // public function resetValue()
    // {
    //     parent::resetValue();
    // }

    /**
     *  validate
     *  @return messages array()
     */
    public function validate()
    {
        $messages = [];

        // email
        $result = filter_var( $this->getEmail(), FILTER_VALIDATE_EMAIL );
        if (!$result) {
          //$messages['email'] = 'Email 格式不正確';
            $messages['email'] = 'The Email is validation fails.';
        }

        return $messages;
    }

    /* ------------------------------------------------------------------------------------------------------------------------
        basic method rewrite or extends
    ------------------------------------------------------------------------------------------------------------------------ */

    /**
     *  Disabled methods
     *  @return array()
     */
    public static function getDisabledMethods()
    {
        // return ['setIpn','setCustomSearch'];
        return [];
    }

    /* ------------------------------------------------------------------------------------------------------------------------
        extends
    ------------------------------------------------------------------------------------------------------------------------ */



    /* ------------------------------------------------------------------------------------------------------------------------
        lazy loading methods
    ------------------------------------------------------------------------------------------------------------------------ */


}
