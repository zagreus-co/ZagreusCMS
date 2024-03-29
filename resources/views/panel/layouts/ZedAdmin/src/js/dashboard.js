// Scroll to active element [zagreus-co/ZedAdmin: issue #2]
const activeElement = document.querySelector("nav ul li.active");
if (activeElement !== null) activeElement.scrollIntoView({ behavior: 'smooth', block: 'end'});

let toggleMenu = (sidebarElement = "aside.sidebar") => {
    document.querySelector(sidebarElement).classList.toggle('hidden');
}

document.addEventListener("click", (event) => {
    const mobile_menu = document.querySelector('aside.sidebar');
    let targetElement = event.target; // Clicked element

    do {
        if (targetElement == document.querySelector('#mobileMenuBtn')) return toggleMenu();
        if (targetElement == mobile_menu) return;
        targetElement = targetElement.parentNode;
    } while (targetElement);
    
    if (!mobile_menu.classList.contains('hidden')) mobile_menu.classList.add('hidden');
});
