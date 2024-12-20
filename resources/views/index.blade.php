@extends('layouts.layout')
@section('title')
{{ __('Package Sample') }}
@endsection
@section('breadcrumbs')
@include('shared.breadcrumbs', ['routes' => [
__('Admin') => route('admin.index'),
__('Skeleton') => null,
]])
@endsection
@section('sidebar')
    @include('layouts.sidebar', ['sidebar'=> Menu::get('sidebar_admin')])
@endsection
@section('css')
    <link rel="stylesheet" href="{{mix('/css/package.css', 'vendor/processmaker/packages/package-skeleton')}}">
@endsection
@section('content')
    <div class="container page-content" id="app-package-skeleton">
        <b-card>
            <b-row class="mb-3">
                <b-col class="col-12 col-md pr-1">
                    <b-input-group>
                        <template #append>
                            <b-button
                            variant="primary"
                            @click="fetch"
                            >
                                <i class="fa fa-search">&nbsp;</i>
                            </b-button>
                        </template>
                        <b-form-input
                            v-model="filter"
                            placeholder="{{__('Search')}}..."
                            aria-label="Search"
                        />
                    </b-input-group>
                </b-col>
                <b-col md="auto" class="col-12 col-md-auto pl-1">
                    <b-button
                        variant="secondary"
                        @click="newRecord"
                    >
                        <i class="fa fa-plus">&nbsp;</i> Record
                    </b-button>
                </b-col>
            </b-row>
            <div class="container-fluid mt-4">
                <sample-listing id="sample-list" ref="listing" :filter="filter" v-on:reload="reload"></sample-listing>
            </div>
        </b-card>
        <sample-modal
            :is-visible="isModalVisible"
            :sample-data="selectedData"
            :modal-title="modalTitle"
            :is-visible.sync="isModalVisible"
            @submit="handleSubmit"
        ></sample-modal>
    </div>
@section('js')
<script src="{{mix('/js/package.js', 'vendor/processmaker/packages/package-skeleton')}}"></script>
@endsection
@endsection
