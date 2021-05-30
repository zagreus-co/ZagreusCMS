let toggleHiddenElement = (element, toggleClass = 'block') => {
    element = document.querySelector(element)
    if ( element.classList.contains('hidden') ) {
        element.classList.replace('hidden', toggleClass);
    } else {
        element.classList.replace(toggleClass, 'hidden');
    }
}

let replyComment = (comment_id) => {
    document.querySelector('#commentReplyForm').scrollIntoView({behavior: 'smooth'});
    document.querySelector('#commentReplyForm input[name=parent_id]').value = comment_id
    document.querySelector('#commentReplyForm div#replyTo').classList.remove('hidden');
    document
        .querySelector('#commentReplyForm div#replyTo p').innerHTML = document.querySelector(`#comment_${comment_id}`).innerHTML;
}

let closeReply = () => {
    document.querySelector('#commentReplyForm input[name=parent_id]').value = 0;
    document.querySelector('#commentReplyForm div#replyTo').classList.add("hidden");
}