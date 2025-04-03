 <div id="page_top" class="section-body top_dark">
    <div class="container-fluid">
        <div class="page-header">
            <div class="left">
                <a href="javascript:void(0)" class="icon menu_toggle mr-3"><i class="fa  fa-align-left"></i></a>
                <h1 class="page-title">Dashboard</h1>                        
            </div>
            <div class="right">
              
                <div class="notification d-flex">

                    <div class="dropdown d-flex">
                        <a class="nav-link icon d-none d-md-flex btn btn-default btn-icon ml-2" data-toggle="dropdown"><i class="fa fa-user"></i></a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"  class="dropdown-item"><i class="dropdown-icon fe fe-log-out"></i> Sign out</button>
                            </form>
                            {{-- <a class="dropdown-item" href="{{route('logout')}}"><i class="dropdown-icon fe fe-log-out"></i> Sign out</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>