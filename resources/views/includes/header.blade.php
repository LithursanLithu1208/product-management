<header>
   
  <!-- nav bar -->
  <div class="col-12 " style="background-color: #2C1708; overflow-x: hidden;">
    <nav class="navbar navbar-expand-lg navbar-dark " >
        <div class="container-fluid">
          <h2 class="text-white ms-5" >Apexx.</h2>
          <button class="navbar-toggler text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" >
            <span class="navbar-toggler-icon text-white"></span>
          </button>
          <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasNavbar2" >
            <div class="offcanvas-header">
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 p-2  " style="font-size: 20px; gap: 78px; margin-right: 78px;">
                <li class="nav-item" >
                    <a class="nav-link" href="#" onclick="navigateTo('home') " style="" >Order Management</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="{{ route('products.index') }}" onclick="navigateTo('about')">Product Management</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('slider.index') }}" onclick="navigateTo('product')">Slider Management</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
  </div>
  
  
  </header>
  
  
  