let toggleHiddenElement = (element, toggleClass = 'block') => {
    element = document.querySelector(element)
    if ( element.classList.contains('hidden') ) {
        element.classList.replace('hidden', toggleClass);
    } else {
        element.classList.replace(toggleClass, 'hidden');
    }
}
