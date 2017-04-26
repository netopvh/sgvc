<!-- Main sidebar -->
<div class="sidebar sidebar-main">
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="category-content">
                <div class="media">
                    <a href="#" class="media-left"><img src="{{ auth()->user()->ldap->getThumbnailEncoded()  }}"
                                                        class="img-circle img-sm" alt=""></a>
                    <div class="media-body">
                        <span class="media-heading text-semibold">{{ text_limit(auth()->user()->name,20) }}</span>
                        <div class="text-size-mini text-muted">
                            <i class="icon-pin text-size-small"></i> &nbsp;Informatica
                        </div>
                    </div>

                    <div class="media-right media-middle">
                        <ul class="icons-list">
                            <li>
                                <a href="#"><i class="icon-cog3"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <!-- Main -->
                    <li class="navigation-header"><span>Gerenciamento</span> <i class="icon-menu"
                                                                                title="Main pages"></i></li>
                    <li class="{{ isUrlActive('/') }}"><a href="{{ route('home') }}"><i class="icon-home4"></i> <span>Início</span></a>
                    </li>
                    <li class="{{ arUrlActive(['contractors','units','companies']) }}">
                        <a href="#"><i class="icon-stack"></i> <span>Cadastros</span></a>
                        <ul class="{{ boolReturn(['contractors','units','companies']) ? '':'hidden-ul' }}">
                            @if(Entrust::can('manage-contratantes'))
                                <li class="{{ isUrlActive('contractors') }}"><a href="{{ route('casas.index') }}"><i
                                                class="icon-office"></i> Contratantes</a></li>
                            @endif
                            @if(Entrust::can('manage-contratados'))
                                <li class="{{ isUrlActive('companies') }}"><a href="{{ route('empresas.index') }}"><i
                                                class="icon-city"></i> Contratados</a></li>
                            @endif
                            @if(Entrust::can('manage-unidades'))
                                <li class="{{ isUrlActive('units') }}"><a href="{{ route('unidades.index') }}"><i
                                                class="icon-store"></i> Unidades / Setor</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="{{ arUrlActive(['contracts','additions']) }}">
                        <a href="#"><i class="icon-stack"></i> <span>Movimentação</span></a>
                        <ul class="{{ boolReturn(['contracts','additions']) ? '':'hidden-ul' }}">
                            @if(Entrust::can('manage-contratos'))
                                <li class="{{ isUrlActive('contracts') }}"><a href="{{ route('contratos.index') }}"><i
                                                class="icon-bookmark"></i> Contratos</a></li>
                            @endif
                            @if(Entrust::can('manage-aditivos'))
                                <li class="{{ isUrlActive('additions') }}"><a href="{{ route('aditivos.index') }}"><i
                                                class="icon-paste2"></i> Aditivos</a></li>
                            @endif
                        </ul>
                    </li>
                    <!-- /main -->

                    <!-- Layout -->
                    @if(Entrust::can('view-admin'))
                        <li class="navigation-header"><span>Administração</span> <i class="icon-menu"
                                                                                    title="Layout options"></i></li>
                        <li class="{{ arUrlActive(['users','roles','logs','configuration']) }}">
                            <a href="#"><i class="icon-lock"></i> <span>Segurança</span></a>
                            <ul class="{{ boolReturn(['roles','users', 'logs','configuration']) ? '':'hidden-ul' }}">
                                @if(Entrust::can('manage-users'))
                                    <li class="{{ isUrlActive('users') }}"><a href="{{ route('users.index') }}"><i
                                                    class="icon-user"></i> Usuários</a></li>
                                @endif
                                @if(Entrust::can('manage-roles'))
                                    <li class="{{ isUrlActive('roles') }}"><a href="{{ route('roles.index') }}"><i
                                                    class="icon-users4"></i> Perfis</a></li>
                                @endif
                                @if(Entrust::can('manage-config'))
                                    <li class="{{ isUrlActive('configuration') }}"><a href="{{ route('config.index') }}"><i
                                                    class="icon-cog6"></i> Parâmetros do Sistema</a></li>
                                @endif
                                @if(Entrust::can('manage-logs'))
                                    <li class="{{ isUrlActive('logs') }}"><a href="{{ route('logs.index') }}"><i
                                                    class="icon-comment"></i> Logs</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                                <!-- /layout -->

                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>
<!-- /main sidebar -->