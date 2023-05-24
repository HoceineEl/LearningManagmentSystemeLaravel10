@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cour.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cours.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cour.fields.id') }}
                        </th>
                        <td>
                            {{ $cour->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cour.fields.nom') }}
                        </th>
                        <td>
                            {{ $cour->nom }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cour.fields.description') }}
                        </th>
                        <td>
                            {!! $cour->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cour.fields.cover') }}
                        </th>
                        <td>
                            @if($cour->cover)
                                <a href="{{ $cour->cover->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $cour->cover->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cour.fields.auteur') }}
                        </th>
                        <td>
                            {{ $cour->auteur->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cours.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#cours_sections" role="tab" data-toggle="tab">
                {{ trans('cruds.section.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="cours_sections">
            @includeIf('admin.cours.relationships.coursSections', ['sections' => $cour->coursSections])
        </div>
    </div>
</div>

@endsection