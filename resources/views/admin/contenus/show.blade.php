@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.contenu.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.contenus.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.contenu.fields.id') }}
                        </th>
                        <td>
                            {{ $contenu->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contenu.fields.lesson') }}
                        </th>
                        <td>
                            {{ $contenu->lesson->label ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contenu.fields.ordre') }}
                        </th>
                        <td>
                            {{ $contenu->ordre }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contenu.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\Contenu::TYPE_SELECT[$contenu->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contenu.fields.id_type') }}
                        </th>
                        <td>
                            {{ $contenu->id_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contenu.fields.description') }}
                        </th>
                        <td>
                            {!! $contenu->description !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.contenus.index') }}">
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
            <a class="nav-link" href="#contenu_videos" role="tab" data-toggle="tab">
                {{ trans('cruds.video.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="contenu_videos">
            @includeIf('admin.contenus.relationships.contenuVideos', ['videos' => $contenu->contenuVideos])
        </div>
    </div>
</div>

@endsection