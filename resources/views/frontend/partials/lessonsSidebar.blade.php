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
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="student-dashboard.html">
                                                <i
                                                    class="sidebar-menu-icon sidebar-menu-icon--left material-icons">adjust</i>
                                                Student
                                            </a>
                                        </li>
                                        <li class="sidebar-submenu-item">
                                            <a class="sidebar-menu-button {{ $nextLesson->id == $lesson->id ? 'active' : '' }}"
                                                href="{{ route('frontend.lesson.show', $nextLesson) }}">
                                                <i
                                                    class="sidebar-menu-icon sidebar-menu-icon--left {{ $nextLesson->id == $lesson->id ? 'active-icon' : 'normal-icon' }}"></i>
                                                <div class="media">
                                                    <div class="media-body">
                                                        <a style="text-decoration: none;"
                                                            @if ($nextLesson->videos->first()) href="{{ route('frontend.lesson.show', ['lesson' => $nextLesson]) }}"
                                                            @else
                                                                href="#" @endif>{{ $nextLesson->label }}</a>
                                                    </div>
                                                    <div class="media-right">
                                                        @if ($nextLesson->videos->first())
                                                            @php
                                                                $hours = floor($nextLesson->videos->first()->duration / 3600);
                                                                $minutes = floor(($nextLesson->videos->first()->duration % 3600) / 60);
                                                                $seconds = $nextLesson->videos->first()->duration % 60;
                                                                
                                                                // Format values with leading zeros if needed
                                                                $formattedHours = str_pad($hours, 2, '0', STR_PAD_LEFT);
                                                                $formattedMinutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
                                                                $formattedSeconds = str_pad($seconds, 2, '0', STR_PAD_LEFT);
                                                            @endphp
                                                            <small>{{ $formattedHours }}:{{ $formattedMinutes }}</small>
                                                        @else
                                                            <small>00:00</small>
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
