    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
        <div>
          <p class="app-sidebar__user-name">{{auth()->user()->name}}</p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="{{route('dashboard')}}"><i class="app-menu__icon bi bi-speedometer"></i><span class="app-menu__label">Dashboard</span></a></li>
       
        @role('SuperAdmin')
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-table"></i><span class="app-menu__label">Company</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{route('companies.create')}}"><i class="icon bi bi-circle-fill"></i> Add Company</a></li>
            <li><a class="treeview-item" href="{{route('companies.index')}}"><i class="icon bi bi-circle-fill"></i> Company List</a></li>
          </ul>
        </li>
        @endrole


        @role('SuperAdmin|Admin')
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-table"></i><span class="app-menu__label">Invitation</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{route('invitation.create')}}"><i class="icon bi bi-circle-fill"></i> Invitee User</a></li>
            <li><a class="treeview-item" href="{{route('invitation.index')}}"><i class="icon bi bi-circle-fill"></i> Invitation List</a></li>
          </ul>
        </li>
        @endrole


      </ul>
    </aside>