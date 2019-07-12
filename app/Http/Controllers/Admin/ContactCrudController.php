<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ContactRequest as StoreRequest;
use App\Http\Requests\ContactRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class ContactCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ContactCrudController extends CrudController
{
    private function contactStatus()
    {
        return [0 => 'Vừa đăng ký', 1 => 'Đang xử lý', 2 => 'Hoàn thành'];
    }

    private function contacSource()
    {
        return ['TEAM_1' => 'TEAM 1', 'TEAM_2' => 'TEAM 2'];
    }

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Contact');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/contact');
        $this->crud->setEntityNameStrings('Đăng Ký', 'Đăng Ký');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();
        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => 'Họ và Tên'
            ],
            [
                'name' => 'phone',
                'label' => 'SĐT'
            ],
            [
                'name' => 'note',
                'label' => 'Địa chỉ',
                'type' => 'textarea'
            ],
            [
                'name' => 'status',
                'label' => 'Trạng thái',
                'type' => 'select_from_array',
                'options' => $this->contactStatus()
            ],
            [
                'name' => 'source',
                'label' => 'Team',
                'type' => 'select_from_array',
                'options' => $this->contacSource()
            ],
            [
                'name' => 'created_at',
                'label' => 'Ngày đăng ký',
                'type' => "date",
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => 'Họ và Tên'
            ],
            [
                'name' => 'phone',
                'label' => 'SĐT'
            ],
            [
                'name' => 'note',
                'label' => 'Địa chỉ',
                'type' => 'textarea'
            ],
            [
                'name' => 'source',
                'label' => 'Team',
                'type' => 'select_from_array',
                'options' => $this->contacSource()
            ],
            [
                'name' => 'status',
                'label' => 'Trạng thái',
                'type' => 'select_from_array',
                'options' => $this->contactStatus()
            ],
        ]);

        $this->crud->enableExportButtons();
        $this->crud->orderBy('created_at', 'desc');

        $this->crud->addFilter([ // select2 filter
            'name' => 'status',
            'type' => 'select2',
            'label'=> 'Trạng thái'
        ], function() {
            return $this->contactStatus();
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'status', $value);
        });

        if (backpack_user()->hasRole('team1')) {
            $this->crud->addClause('where', 'source', 'TEAM_1');
        }
        if (backpack_user()->hasRole('team2')) {
            $this->crud->addClause('where', 'source', 'TEAM_2');
        }

        // add asterisk for fields that are required in ContactRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
