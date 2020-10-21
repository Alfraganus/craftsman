<?php

namespace backend\models;

use backend\models\User;

/**
 * This is the model class for vendors.
 */
class Vendors extends User
{
    /**
     * Get items
     *
     * @return object
     */
    public static function getItems()
    {
        $search = input_get('s');
        $sort = input_get('sort');

        $query = self::find()
            ->leftJoin('profile', 'profile.user_id = users.id')
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = users.id')
            ->andWhere(['=', 'auth_assignment.item_name', 'seller']);

        if ($search) {
            if (is_email($search)) {
                $query->andWhere(['like', 'users.email', $search]);
            } else {
                $query->andWhere(['or',
                    ['profile.name' => $search],
                    ['profile.surname' => $search],
                    ['profile.lastname' => $search],
                    ['users.username' => $search],
                    ['users.email' => $search],
                ]);
            }
        }

        if ($sort == 'a-z') {
            $sort_query = ['profile.name' => SORT_ASC];
        } elseif ($sort == 'z-a') {
            $sort_query = ['profile.name' => SORT_DESC];
        } elseif ($sort == 'oldest') {
            $sort_query = ['users.created_at' => SORT_ASC];
        } else {
            $sort_query = ['users.created_at' => SORT_DESC];
        }

        $query->orderBy($sort_query);

        return $query;
    }

    /**
     * Page types
     *
     * @param boolean $active
     * @return void
     */
    public static function getPageTypes($active = '')
    {
        $page_types = array(
            '' => array(
                'name' => 'All',
                'active' => false,
                'count' => self::countAll(),
            ),
            'active' => array(
                'name' => 'Active',
                'active' => false,
                'count' => self::countActive(),
            ),
            'pending' => array(
                'name' => 'Pending',
                'active' => false,
                'count' => self::countPending(),
            ),
            'blocked' => array(
                'name' => 'Blocked',
                'active' => false,
                'count' => self::countBanned(),
            ),
            'deleted' => array(
                'name' => 'Deleted',
                'active' => false,
                'count' => self::countDeleted(),
            ),
        );

        if (isset($page_types[$active])) {
            $page_types[$active]['active'] = true;
        }

        return $page_types;
    }

    /**
     * Count all
     *
     * @param array $where
     * @return int
     */
    public static function countAll($where = array())
    {
        $query = User::find()
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = users.id')
            ->where(['=', 'auth_assignment.item_name', 'seller']);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        return $query->count();
    }

    /**
     * Count all
     *
     * @param array $where
     * @return int
     */
    public static function countActive($where = array())
    {
        $query = User::find()
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = users.id')
            ->where(['=', 'auth_assignment.item_name', 'seller'])
            ->andWhere(['users.deleted' => 0, 'users.status' => User::ACTIVE]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        return $query->count();
    }

    /**
     * Count pending
     *
     * @param array $where
     * @return int
     */
    public static function countPending($where = array())
    {
        $query = User::find()
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = users.id')
            ->where(['=', 'auth_assignment.item_name', 'seller'])
            ->andWhere(['users.deleted' => 0, 'users.status' => User::PENDING]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        return $query->count();
    }

    /**
     * Count banned
     *
     * @param array $where
     * @return int
     */
    public static function countBanned($where = array())
    {
        $query = User::find()
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = users.id')
            ->where(['=', 'auth_assignment.item_name', 'seller'])
            ->andWhere(['users.deleted' => 0, 'users.status' => User::BANNED]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        return $query->count();
    }

    /**
     * Count deleted
     *
     * @param array $where
     * @return int
     */
    public static function countDeleted($where = array())
    {
        $query = User::find()
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = users.id')
            ->where(['=', 'auth_assignment.item_name', 'seller'])
            ->andWhere(['users.deleted' => 1]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        return $query->count();
    }

    /**
     * Search vendor
     *
     * @param string $keyword
     * @param array $where
     * @return object
     */
    public static function search($keyword, $where = array())
    {
        if (is_string($keyword) && $keyword) {
            $model = User::find()
                ->join('INNER JOIN', 'profile', 'profile.user_id = users.id')
                ->andWhere(['or',
                    ['users.status' => User::ACTIVE],
                    ['users.status' => User::PENDING],
                ]);

            if (is_email($keyword)) {
                $model->andWhere(['like', 'users.email', $keyword]);
            } elseif ($keyword) {
                $model->andWhere(['or',
                    ['like', 'profile.name', $keyword],
                    ['like', 'profile.surname', $keyword],
                    ['like', 'profile.lastname', $keyword],
                    ['like', 'users.username', $keyword],
                    ['like', 'users.email', $keyword],
                ]);
            }

            if (is_array($where) && $where) {
                $model->andWhere($where);
            }

            $model->orderBy('profile.name', 'ASC');
            $model->with('profile');

            return $model->all();
        }
    }
}
