// Set Navbar Fixed
function navbarFixed(el) {
    let classes = ['position-sticky', 'blur', 'shadow-blur', 'mt-4', 'left-auto', 'top-1', 'z-index-sticky'];
    const navbar = document.getElementById('navbarBlur');
  
    if (!el.getAttribute("checked")) {
      navbar.classList.add(...classes);
      navbar.setAttribute('navbar-scroll', 'true');
      navbarBlurOnScroll('navbarBlur');
      el.setAttribute("checked", "true");
    } else {
      navbar.classList.remove(...classes);
      navbar.setAttribute('navbar-scroll', 'false');
      navbarBlurOnScroll('navbarBlur');
      el.removeAttribute("checked");
    }
  };
  
  
  // Set Navbar Minimized
  function navbarMinimize(el) {
    var sidenavShow = document.getElementsByClassName('g-sidenav-show')[0];
  
    if (!el.getAttribute("checked")) {
      sidenavShow.classList.remove('g-sidenav-pinned');
      sidenavShow.classList.add('g-sidenav-hidden');
      el.setAttribute("checked", "true");
    } else {
      sidenavShow.classList.remove('g-sidenav-hidden');
      sidenavShow.classList.add('g-sidenav-pinned');
      el.removeAttribute("checked");
    }
  }
  
  // Navbar blur on scroll
  function navbarBlurOnScroll(id) {
    const navbar = document.getElementById(id);
    let navbarScrollActive = navbar ? navbar.getAttribute("data-scroll") : false;
    let scrollDistance = 5;
    let classes = ['blur', 'shadow-blur', 'left-auto'];
    let toggleClasses = ['shadow-none'];
  
    if (navbarScrollActive == 'true') {
      window.onscroll = debounce(function() {
        if (window.scrollY > scrollDistance) {
          blurNavbar();
        } else {
          transparentNavbar();
        }
      }, 10);
    } else {
      window.onscroll = debounce(function() {
        transparentNavbar();
      }, 10);
    }
  
    var isWindows = navigator.platform.indexOf('Win') > -1 ? true : false;
  
    if (isWindows) {
      var content = document.querySelector('.main-content');
      if (navbarScrollActive == 'true') {
        content.addEventListener('ps-scroll-y', debounce(function() {
          if (content.scrollTop > scrollDistance) {
            blurNavbar();
          } else {
            transparentNavbar();
          }
        }, 10));
      } else {
        content.addEventListener('ps-scroll-y', debounce(function() {
          transparentNavbar();
        }, 10));
      }
    }
  
    function blurNavbar() {
      navbar.classList.add(...classes)
      navbar.classList.remove(...toggleClasses)
  
      toggleNavLinksColor('blur');
    }
  
    function transparentNavbar() {
      navbar.classList.remove(...classes)
      navbar.classList.add(...toggleClasses)
  
      toggleNavLinksColor('transparent');
    }
  
    function toggleNavLinksColor(type) {
      let navLinks = document.querySelectorAll('.navbar-main .nav-link')
      let navLinksToggler = document.querySelectorAll('.navbar-main .sidenav-toggler-line')
  
      if (type === "blur") {
        navLinks.forEach(element => {
          element.classList.remove('text-body')
        });
  
        navLinksToggler.forEach(element => {
          element.classList.add('bg-dark')
        });
      } else if (type === "transparent") {
        navLinks.forEach(element => {
          element.classList.add('text-body')
        });
  
        navLinksToggler.forEach(element => {
          element.classList.remove('bg-dark')
        });
      }
    }
  }