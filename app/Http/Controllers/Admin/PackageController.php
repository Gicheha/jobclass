<?php
/**
 * JobClass - Geolocalized Job Board Script
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers\Admin;

use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\PackageRequest as StoreRequest;
use App\Http\Requests\Admin\PackageRequest as UpdateRequest;

class PackageController extends PanelController
{
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\Package');
		$this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/packages');
		$this->xPanel->setEntityNameStrings(trans('admin::messages.package'), trans('admin::messages.packages'));
		$this->xPanel->enableReorder('name', 1);
		$this->xPanel->enableDetailsRow();
		$this->xPanel->allowAccess(['reorder', 'details_row']);
		if (!request()->input('order')) {
			$this->xPanel->orderBy('lft', 'ASC');
		}
		
		$this->xPanel->addButtonFromModelFunction('top', 'bulk_delete_btn', 'bulkDeleteBtn', 'end');
		
		/*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/
		// COLUMNS
		$this->xPanel->addColumn([
			'name'  => 'id',
			'label' => '',
			'type'  => 'checkbox',
			'orderable' => false,
		]);
		$this->xPanel->addColumn([
			'name'  => 'name',
			'label' => trans("admin::messages.Name"),
		]);
		$this->xPanel->addColumn([
			'name'  => 'price',
			'label' => trans("admin::messages.Price"),
		]);
		$this->xPanel->addColumn([
			'name'  => 'currency_code',
			'label' => trans("admin::messages.Currency"),
		]);/*$this->xPanel->addColumn([
			'name'  => 'max_user',
			'label' => 'max_user',
		]);$this->xPanel->addColumn([
			'name'  => 'max_post',
			'label' => 'max_post',
		]);$this->xPanel->addColumn([
			'name'  => 'highlight_job',
			'label' => 'highlight_job',
		]);$this->xPanel->addColumn([
			'name'  => 'feature_employer',
			'label' => 'feature_employer',
		]);$this->xPanel->addColumn([
			'name'  => 'resume_download',
			'label' => 'resume_download',
		]);$this->xPanel->addColumn([
			'name'  => 'resume_print',
			'label' => 'resume_print',
		]);*/
		$this->xPanel->addColumn([
			'name'          => 'active',
			'label'         => trans("admin::messages.Active"),
			'type'          => 'model_function',
			'function_name' => 'getActiveHtml',
			'on_display'    => 'checkbox',
		]);
		
		// FIELDS
		$this->xPanel->addField([
			'name'              => 'name',
			'label'             => 'Package Name',
			// 'label'             => trans("admin::messages.Name"),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => trans("admin::messages.Name"),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'max_post',
			'label'             => 'Max Job Post',
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => 'Maximum Job Post Number',
			],
			'hint'              => 'Maximum Job Post Number',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		/*$this->xPanel->addField([
			'name'              => 'short_name',
			'label'             => trans('admin::messages.Short Name'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => trans('admin::messages.Short Name'),
			],
			'hint'              => trans('admin::messages.Short name for ribbon label'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);*/
		$this->xPanel->addField([
			'name'              => 'max_user',
			'label'             => 'Maximum user search',
			'type'              => 'text',
			'hint'              => 'Maximum user search Number',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		$this->xPanel->addField([
			'name'              => 'duration',
			'label'             => 'Package duration',
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => 'Package Duration',
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'price',
			'label'             => 'Package Price',
			// 'label'             => trans("admin::messages.Price"),
			'type'              => 'text',
			'placeholder'       => trans("admin::messages.Price"),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);$this->xPanel->addField([
			'name'              => 'highlight_job',
			'label'             => 'Highlight Job',
			// 'label'             => trans("admin::messages.Price"),
			'type'              => 'text',
			'placeholder'       => 'Highlight Job',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);$this->xPanel->addField([
			'name'              => 'feature_employer',
			'label'             => 'Feature Employer',
			// 'label'             => trans("admin::messages.Price"),
			'type'              => 'text',
			'placeholder'       => 'Feature Employer',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);$this->xPanel->addField([
			'name'              => 'resume_download',
			'label'             => 'Resume Downloadable',
			// 'label'             => trans("admin::messages.Price"),
			'type'              => 'text',
			'placeholder'       => 'Resume Downloadable',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);$this->xPanel->addField([
			'name'              => 'resume_print',
			'label'             => 'Resume Printable',
			// 'label'             => trans("admin::messages.Price"),
			'type'              => 'text',
			'placeholder'       => 'Resume Printable',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		$this->xPanel->addField([
			'label'             => trans("admin::messages.Currency"),
			'name'              => 'currency_code',
			'model'             => 'App\Models\Currency',
			'entity'            => 'currency',
			'attribute'         => 'code',
			'type'              => 'select2',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		/*$this->xPanel->addField([
			'name'              => 'ribbon',
			'label'             => trans('admin::messages.Ribbon'),
			'type'              => 'enum',
			'hint'              => trans('admin::messages.Show ads with ribbon when viewing ads in search results list'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'has_badge',
			'label'             => trans("admin::messages.Show ads with a badge (in addition)"),
			'type'              => 'checkbox',
			'hint'              => '<br><br>',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);
		
		$this->xPanel->addField([
			'label'             => trans("admin::messages.Currency"),
			'name'              => 'currency_code',
			'model'             => 'App\Models\Currency',
			'entity'            => 'currency',
			'attribute'         => 'code',
			'type'              => 'select2',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		
		$this->xPanel->addField([
			'name'       => 'description',
			'label'      => trans('admin::messages.Description'),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => trans('admin::messages.Description'),
			],
		]);
		$this->xPanel->addField([
			'name'              => 'lft',
			'label'             => trans('admin::messages.Position'),
			'type'              => 'text',
			'hint'              => trans('admin::messages.Quick Reorder') . ': '
				. trans('admin::messages.Enter a position number.') . ' '
				. trans('admin::messages.NOTE: High number will allow to show ads in top in ads listing. Low number will allow to show ads in bottom in ads listing.'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'active',
			'label'             => trans("admin::messages.Active"),
			'type'              => 'checkbox',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);*/
	}
	
	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}
	
	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
}
