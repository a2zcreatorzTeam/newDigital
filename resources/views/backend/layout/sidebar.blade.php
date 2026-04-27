  <aside class="sidebar">
      <div class="sidebar-header">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZvYtBKiDKEeWExM5MB0no20Z_eZaE0two5g&s" alt="Icon">
          <h2>State Life Policy</h2>
      </div>

      <nav class="sidebar-nav">
          <a class="nav-item active" href="{{route('admin.dashboard')}}" data-target="dashboard">
              <i class="fa-solid fa-chart-pie"></i> Dashboard
          </a>
          @can('role-list')
          <div class="nav-item" data-target="manager">
              <a href="{{route('roles.index')}}">
                  <i class="fa-solid fa-user-shield"></i> Roles Management
              </a>
          </div>
          @endcan
          @can('user-list')
          <div class="nav-item" data-target="manager">
              <a href="{{route('users.index')}}">
                  <i class="fa-solid fa-users"></i> Users Management
              </a>
          </div>
          @endcan
          @can('class-list')
          <div class="nav-item" data-target="manager">
              <a href="{{route('class.index')}}">
                 <i class="fa-solid fa-chalkboard-user"></i> Category Management
              </a>
          </div>
          @endcan
          @can('subclass-list')
          <div class="nav-item" data-target="manager">
              <a href="{{route('subclass.filter')}}">
                 <i class="fa-solid fa-layer-group"></i> Policies Management
              </a>
          </div>
          @endcan

      </nav>

      <div class="sidebar-footer">
          <div class="user-profile">
              <div class="avatar" id="user-avatar">A</div>
              <div>
                  <div style="font-size: 0.875rem; font-weight: 500;" id="user-name">Admin User</div>
              </div>
          </div>

          <a href="{{route('admin.logout.user')}}" class="btn btn-outline" style="border:none; color: #cbd5e1; padding: 0.5rem;" title="Logout">
              <i class="fa-solid fa-sign-out-alt"></i>
          </a>
      </div>
  </aside>