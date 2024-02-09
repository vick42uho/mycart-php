/* scroll Bar progressbar */

const progressEl = document.querySelector(".progress")
window.onscroll = () => scrollProgress()

function scrollProgress() {
  const pageHeight =
    document.documentElement.scrollHeight -
    document.documentElement.clientHeight;
  const scrollTop = document.documentElement.scrollTop
  const scrollPercentage = (scrollTop / pageHeight) * 100;
  progressEl.style.visibility = "visible"
  progressEl.style.width = scrollPercentage + "%"
}

/* scroll to top*/
const scrollBtn = document.querySelector(".top")
const rootEl = document.documentElement
document.addEventListener("scroll", showBtn)
scrollBtn.addEventListener("click",scrollToTop)

function showBtn(){
    const scrollTotal = rootEl.scrollHeight - rootEl.clientHeight
    if(rootEl.scrollTop/scrollTotal>0.3){
        scrollBtn.classList.add("show-btn")
    }else{
        scrollBtn.classList.remove("show-btn")
    }
}

function scrollToTop(){
    rootEl.scrollTo({
    top:0,
    behavior:"smooth"
    })
}


/* scroll to top */
const nav = document.querySelector(".nav")
window.addEventListener("scroll",stickyNavbar)

function stickyNavbar(){
  if(window.scrollY>nav.offsetHeight){
    nav.classList.add("active")
  }else{
    nav.classList.remove("active")
  }
}

