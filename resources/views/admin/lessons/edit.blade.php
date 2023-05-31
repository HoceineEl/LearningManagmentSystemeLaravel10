@extends('layouts.admin')
@section('content')

<div class="card">
      
    <div class="card-body" id="main">
      
        {{-- <ul class="section-list">
          <li class="section">
            <i class="fa fa-bars handle-section"></i>
            <span id="section-title">Item 6</span>
            <ul class="lesson-list">
              <button id="" class="btn btn-outline-dark btn-el">+ Add Lesson</button>
                <li class="lesson">
                  <i class="fa fa-bars handle"></i>
                  <div id="lesson-box" style="display: inline;">
                    <input value="New Lesson" class="form-control input m-2 border border-dark" type="text" name="" id="input">
                    <button class="btn btn-primary button save-button">Save</button>
                    <button class="btn btn-light button cancel-button">Cancel</button>
                  </div>
                  <div class="dropdown">
                    <span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v handle"></i>
                    </span>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </div>
                </li>
              <li class="lesson">
                <i class="fa fa-bars handle"></i>
                <div id="lesson-box" style="display: inline;">
                  <input value="New Lesson" class="form-control input m-2 border border-dark" type="text" id="input">
                  <button class="btn btn-primary button save-button">Save</button>
                  <button class="btn btn-light button cancel-button">Cancel</button>
                </div>
              </li>
            </ul>
          </li>
        </ul> --}}
    
        @foreach($sections as $section)
        <ul class="section-list" data-section-id="{{ $section->id }}">
          <li class="section" data-section-id="{{ $section->id }}">
            <div class="d-flex justify-content-between">
              <div>
                <i class="fa fa-bars handle-section"></i>
                <span id="section-title">{{ $section->label }}</span>
              </div>
              <div class="d-flex">
                <span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v handle"></i></span>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item" href="#">Edit</a></li>
                  <li><a class="dropdown-item" href="#">Delete</a></li>
                  {{-- <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
                </ul>
              </div>
            </div>
            <ul class="lesson-list" data-section-id="{{ $section->id }}">
              <button  class="btn btn-outline-dark btn-el">+ Add Lesson</button>
              @if(isset($lessons[$section->id]))
              @foreach($lessons[$section->id] as $lesson)
              <li class="lesson d-flex justify-content-between" data-lesson-id="{{ $lesson->id }}">
                <div>
                  <i class="fa fa-bars handle"></i>
                  <a href="#" id="lesson-link">{{ $lesson->label }}</a>
                </div>
                <div class="d-flex">
                  <span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v handle"></i></span>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#">Edit</a></li>
                    <li><a class="dropdown-item" href="#">Delete</a></li>
                    {{-- <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
                  </ul>
                </div>
              </li>
              @endforeach
              @endif
            </ul>
          </li>
        </ul>
        @endforeach
      </div>
      <div>
        <button class="btn btn-dark" id="btn">+ Add New Section</button>
      </div>
</div>




@endsection



@endsection