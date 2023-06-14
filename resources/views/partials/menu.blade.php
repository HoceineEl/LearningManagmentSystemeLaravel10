<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li>
            <select class="searchable-field form-control">

            </select>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ route('dashboard') }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li
                class="c-sidebar-nav-dropdown {{ request()->is('admin/permissions*') ? 'c-show' : '' }} {{ request()->is('admin/roles*') ? 'c-show' : '' }} {{ request()->is('admin/users*') ? 'c-show' : '' }} {{ request()->is('admin/audit-logs*') ? 'c-show' : '' }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.permissions.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.roles.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.users.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.audit-logs.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/audit-logs') || request()->is('admin/audit-logs/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('cour_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.cours.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/cours') || request()->is('admin/cours/*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-chalkboard c-sidebar-nav-icon">

                    </i>
                    Courses
                </a>
            </li>
        @endcan
        @can('section_access')
            {{-- <li class="c-sidebar-nav-item">
                <a href="{{ route('section.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/sections') || request()->is('admin/sections/*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-puzzle-piece c-sidebar-nav-icon">
                    </i>
                    {{ trans('cruds.section.title') }}
                </a>
            </li> --}}
        @endcan
        {{-- @can('lesson_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('videos.create') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/videos') || request()->is('admin/videos/*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-video c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.video.title') }}
                </a>
            </li>
        @endcan --}}
        @can('quiz_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.quizzes.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/quizzes') || request()->is('admin/quizzes/*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-comments c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.quiz.title') }}
                </a>
            </li>
        @endcan
        @can('quiz_question_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.quiz-questions.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/quiz-questions') || request()->is('admin/quiz-questions/*') ? 'c-active' : '' }}">
                    <i class="fa-fw far fa-comment c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.quizQuestion.title') }}
                </a>
            </li>
        @endcan
        @can('question_reponse_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.question-reponses.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/question-reponses') || request()->is('admin/question-reponses/*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-file c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.questionReponse.title') }}
                </a>
            </li>
        @endcan
        {{-- @can('utilisateur_reponse_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.utilisateur-reponses.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/utilisateur-reponses') || request()->is('admin/utilisateur-reponses/*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-user-edit c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.utilisateurReponse.title') }}
                </a>
            </li>
        @endcan --}}
        {{-- @can('score_quiz_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.score-quizzes.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/score-quizzes') || request()->is('admin/score-quizzes/*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-star c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.scoreQuiz.title') }}
                </a>
            </li>
        @endcan --}}
        @can('progression_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.progressions.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/progressions') || request()->is('admin/progressions/*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-spinner c-sidebar-nav-icon">
                    </i>
                    {{ trans('cruds.progression.title') }}
                </a>
            </li>
        @endcan
        @can('commentaire_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.commentaires.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/commentaires') || request()->is('admin/commentaires/*') ? 'c-active' : '' }}">
                    <i class="fa-fw far fa-comment-dots c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.commentaire.title') }}
                </a>
            </li>
        @endcan
        @can('contenu_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.contenus.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/contenus') || request()->is('admin/contenus/*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-file-signature c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.contenu.title') }}
                </a>
            </li>
        @endcan

        @can('user_alert_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.user-alerts.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/user-alerts') || request()->is('admin/user-alerts/*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-bell c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userAlert.title') }}
                </a>
            </li>
        @endcan
        @php($unread = \App\Models\QaTopic::unreadCount())
        <li class="c-sidebar-nav-item">
            <a href="{{ route('admin.messenger.index') }}"
                class="{{ request()->is('admin/messenger') || request()->is('admin/messenger/*') ? 'c-active' : '' }} c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fa-fw fa fa-envelope">

                </i>
                <span>{{ trans('global.messages') }}</span>
                @if ($unread > 0)
                    <strong>( {{ $unread }} )</strong>
                @endif

            </a>
        </li>
        @if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}"
                        href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link"
                onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>
