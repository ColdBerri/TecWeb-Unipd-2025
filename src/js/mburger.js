 function apriMenu() {
      const menuHamberger = document.querySelector('.nascondi')
      menuHamberger.classList.remove("nascondi")
      menuHamberger.classList.add("menuHamberger")
    }

    function chiudiMenu(){
      const menuHamberger = document.querySelector('.menuHamberger')
      menuHamberger.classList.remove("menuHamberger")
      menuHamberger.classList.add("nascondi")
    }