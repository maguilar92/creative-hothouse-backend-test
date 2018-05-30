<?php

return [
    /*
     **************************************************************************
     * Repository Pagination Limit Default
     **************************************************************************
     */
    'pagination' => [
        'limit' => 15,
    ],

    /*
     **************************************************************************
     * Cache Config
     **************************************************************************
     */
    'cache'      => [
        /*
         **************************************************************************
         * Cache Status
         **************************************************************************
         */
        'enabled'    => true,

        /*
         **************************************************************************
         * Cache Minutes
         **************************************************************************
         *
         * Time of expiration cache
         *
         */
        'minutes'    => 30,

        /*
         ***************************************************************************
         * Cache Repository
         ***************************************************************************
         *
         * Instance of Illuminate\Contracts\Cache\Repository
         *
         */
        'repository' => 'cache',

        /*
         **************************************************************************
         * Cache Clean Listener
         **************************************************************************
         */
        'clean'      => [

            /*
             **************************************************************************
             * Enable clear cache on repository changes
             **************************************************************************
             */
            'enabled' => true,

            /*
             **************************************************************************
             * Actions in Repository
             **************************************************************************
             *
             * create : Clear Cache on create Entry in repository
             * insert : Clear Cache on insert Entry in repository
             * update : Clear Cache on update Entry in repository
             * delete : Clear Cache on delete Entry in repository
             * restore : Clear Cache on restore Entry in repository
             *
             */
            'on'      => [
                'create'  => true,
                'insert'  => true,
                'update'  => true,
                'delete'  => true,
                'restore' => true,
            ],

        ],

        'params'     => [
            /*
            ***************************************************************************
            * Skip Cache Params
            ***************************************************************************
            *
            *
            * Ex: http://es.hoy*voy.com/?search=lorem&skipCache=true
            *
            */
            'skipCache' => 'skipCache',
        ],

        /*
        ***************************************************************************
        * Methods Allowed
        ***************************************************************************
        *
        * methods cacheable : getDataForTable, all, get, pluck, exists, count, min, max, sum, avg, paginate, find, findOrFail, first, firstOrFail
        *
        * Ex:
        *
        * 'only'  =>['all','paginate'],
        *
        * or
        *
        * 'except'  =>['find'],
        */
        'except'    => [],
    ],
];
