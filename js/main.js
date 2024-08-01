const navItems = document.querySelector('.nav__items');
const openNavBtn = document.querySelector('#open__nav-btn');
const closeNavBtn = document.querySelector('#close__nav-btn');

const openNav = () => {
    navItems.style.display = 'flex';
    openNavBtn.style.display = 'none';
    closeNavBtn.style.display = 'inline-block';
};

const closeNav = () => {
    navItems.style.display = 'none';
    openNavBtn.style.display = 'inline-block';
    closeNavBtn.style.display = 'none';
};

openNavBtn.addEventListener('click', openNav);
closeNavBtn.addEventListener('click', closeNav);

// Function to check the window size and adjust navigation accordingly
const checkWindowSize = () => {
    if (window.innerWidth > 1024) {
        // If the window is wider than 1024px, ensure nav items are displayed and buttons are hidden
        navItems.style.display = 'flex';
        openNavBtn.style.display = 'none';
        closeNavBtn.style.display = 'none';
    } else {
        // If the window is 1024px or narrower, ensure nav items are hidden and open button is displayed
        navItems.style.display = 'none';
        openNavBtn.style.display = 'inline-block';
        closeNavBtn.style.display = 'none';
    }
};

// Add a resize event listener
window.addEventListener('resize', checkWindowSize);

// Initial check
checkWindowSize();


const sidebar = document.querySelector('aside');
const ShowSideBarBtn = document.querySelector('#show__sidebar-btn');

const HideSidebarBtn = document.querySelector('#hide__sidebar-btn');

const showSidebar= () => {
    sidebar.style.left= '0';
    showSidebarBtn.style.display= 'none';
    HideSidebarBtn.style.display= 'inline-block';

}

const HideSidebar= () => {
    sidebar.style.left= '0';
    hideeSidebarBtn.style.display= 'inline-block';
    HideSidebarBtn.style.display= 'none';
    
}

ShowSideBarBtn.addEventListener('click', showSidebar)