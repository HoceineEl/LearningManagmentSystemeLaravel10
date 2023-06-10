<div class="mdk-drawer js-mdk-drawer" id="default-drawer">
        <div class="sidebar sidebar-left  mdk-drawer__content o-hidden" data-perfect-scrollbar>
            <div class="sidebar-p-y">
                <ul class="sidebar-menu sm-active-button">
                   @foreach ($course->sections->sortBy('position') as $section)
                        @if ($section->lessons->count() > 0)
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" data-bs-toggle="collapse"
                                    href="#section{{ $section->id }}">
                                    <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">format_list_bulleted</i>
                                    {{ $section->label }}
                                </a>
                                <ul class="sidebar-submenu collapse" id="section{{ $section->id }}">
                                    @foreach ($section->lessons->sortBy('position') as $nextLesson)
                                        <li class="sidebar-submenu-item">
                                            <a class="sidebar-menu-button {{ $nextLesson->id == $lesson->id ? 'text-success' : '' }}"
                                                 href="{{ route('frontend.lesson.show', ['lesson' => $nextLesson]) }}">
                                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">play_circle_outline</i>
                                                <span>{{ $nextLesson->label }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
</div>
