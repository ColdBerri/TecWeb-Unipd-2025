 function apriMenu() {
      const menuHamberger = document.querySelector('.nascondi')
      const overlay = document.querySelector('.overlayNascondi')
      overlay.classList.remove("overlayNascondi")
      overlay.classList.add("overlay")
      menuHamberger.classList.remove("nascondi")
      menuHamberger.classList.add("menuHamberger")
    }

    function chiudiMenu(){
      const menuHamberger = document.querySelector('.menuHamberger')
      const overlay = document.querySelector('.overlay')
      overlay.classList.remove("overlay")
      overlay.classList.add("overlayNascondi")
      menuHamberger.classList.remove("menuHamberger")
      menuHamberger.classList.add("nascondi")
    }