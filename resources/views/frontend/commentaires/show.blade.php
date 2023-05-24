@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.commentaire.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.commentaires.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commentaire.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $commentaire->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commentaire.fields.lecon') }}
                                    </th>
                                    <td>
                                        {{ $commentaire->lecon->label ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commentaire.fields.utilisateur') }}
                                    </th>
                                    <td>
                                        {{ $commentaire->utilisateur->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commentaire.fields.commentaire') }}
                                    </th>
                                    <td>
                                        {!! $commentaire->commentaire !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commentaire.fields.date_time') }}
                                    </th>
                                    <td>
                                        {{ $commentaire->date_time }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commentaire.fields.parent') }}
                                    </th>
                                    <td>
                                        {{ $commentaire->parent->date_time ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commentaire.fields.created_at') }}
                                    </th>
                                    <td>
                                        {{ $commentaire->created_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.commentaires.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection