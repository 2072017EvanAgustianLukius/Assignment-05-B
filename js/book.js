function editBook(isbn){
    window.location = "index.php?menu=book_edit&gid=" + isbn;
}

function UploadCover(isbn){
    window.location = "index.php?menu=upload&gisbn=" + isbn;
}
function deleteBook(isbn){
    const confirmation = window.confirm("Are you Sure Want to delete this data?");
    if(confirmation){
        window.location = "index.php?menu=book&com=del&gisbn=" + isbn;
    }
}