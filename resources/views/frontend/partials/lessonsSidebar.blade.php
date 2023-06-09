<div class="mdk-drawer js-mdk-drawer" id="default-drawer">
    <div class="mdk-drawer__content">
        <div class="sidebar sidebar-left sidebar-dark bg-dark o-hidden" data-perfect-scrollbar>
            <div class="sidebar-p-y">
                <ul class="sidebar-menu sm-active-button-bg">

                    <li class="sidebar-menu-item">
                        <a class="sidebar-menu-button" href="student-dashboard.html">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">adjust</i>
                            Student
                        </a>
                    </li>

                    @foreach ($course->sections as $section)
                        @if ($section->lessons->count() > 0)
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" data-bs-toggle="collapse"
                                    href="#section{{ $section->id }}">
                                    <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">folder</i>
                                    {{ $section->label }}
                                </a>
                                <ul class="sidebar-submenu collapse" id="section{{ $section->id }}">
                                    @foreach ($section->lessons as $nextLesson)
                                        <li class="sidebar-submenu-item">
                                            <a class="sidebar-menu-button {{ $nextLesson->id == $lesson->id ? 'active' : '' }}"
                                                @if ($nextLesson->videos->first()) href="{{ route('frontend.lesson.show', ['lesson' => $nextLesson]) }}"
                                                @else
                                                    href="#" @endif>
                                                <i
                                                    class="sidebar-menu-icon sidebar-menu-icon--left {{ $nextLesson->id == $lesson->id ? 'active-icon' : 'normal-icon' }}"></i>
                                                <div class="media">
                                                    <div class="media-body">
                                                        <span>{{ $nextLesson->label }}</span>
                                                    </div>
                                                    <div class="media-right">
                                                        @if ($nextLesson->videos->first())
                                                            @php
                                                                $duration = $nextLesson->videos->first()->duration;
                                                                $formattedDuration = gmdate('H:i:s', $duration);
                                                            @endphp
                                                            <small>
                                                                <i class="bi bi-clock"></i>
                                                                {{ $formattedDuration }}
                                                            </small>
                                                        @else
                                                            <small>
                                                                <i class="bi bi-clock"></i>
                                                                00:00:00
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
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
</div>
