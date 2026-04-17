function store(url, data) {
    axios.post(url, data)
        .then(function (response) {
            showMessage(response.data);
            clearForm();
            clearAndHideErrors();

        })
        .catch(function (error) {

            if (error.response.data.errors !== undefined) {
                showErrorMessages(error.response.data.errors);
            } else {
                showMessage(error.response.data);
            }
        });

}

function storepart(url, data) {

    axios.post(url, data)

        .then(function (response) {
            showMessage(response.data);
            clearForm();
            clearAndHideErrors();

        })

        .catch(function (error) {

            if (error.response.data.errors !== undefined) {
                showErrorMessages(error.response.data.errors);
            } else {

                showMessage(error.response.data);
            }
        });

}
function storeRoute(url, data) {
    axios.post(url, data, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
})
        .then(function (response) {
                window.location = response.data.redirect;
             // showMessage(response.data);
            // clearForm();
            // clearAndHideErrors();

        })
        .catch(function (error) {

            if (error.response.data.errors !== undefined) {
                showErrorMessages(error.response.data.errors);
            } else {

                showMessage(error.response.data);
            }
        });
}
function storeRedirect (url, data, redirectUrl) {
    axios.post( url, data)
        .then(function (response) {
            console.log(response);
            if (redirectUrl != null)
                window.location.href = redirectUrl;
        })
        .catch(function (error) {
            console.log(error.response);
        });
}

function update (url, data, redirectUrl) {
    axios.put( url, data)

        .then(function (response) {
            console.log(response);

            if (redirectUrl != null)
                window.location.href = redirectUrl;
        })
        .catch(function (error) {
            console.log(error.response);
        });
}
function updateRoute (url, data) {
    axios.put( url, data)

        .then(function (response) {
            console.log(response);

        window.location = response.data.redirect;

        })
        .catch(function (error) {
            console.log(error.response);
        });
}
function updateReload (url, data, redirectUrl) {
    axios.put( url, data)
        .then(function (response) {
            console.log(response);
            location.reload()
        })
        .catch(function (error) {
            console.log(error.response);
        });
}
function updatePage(url, data) {
    axios.post(url, data)
        .then(function (response) {
            console.log(response);
            location.reload()
            // showMessage(response.data);
         })
        .catch(function (error) {
            console.log(error.response);
        });
}

function confirmDestroy(url, td) {
    Swal.fire({
        title: 'هل أنت متأكد من عملية الحذف ؟',
        text: "لا يمكن التراجع عن عملية الحذف",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم',
        cancelButtonText: 'لا',
    }).then((result) => {
        if (result.isConfirmed) {
            destroy(url, td);
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'تمت عملية الحذف بنجاح',
                showConfirmButton: false,
                timer: 1500
              })

        }else{

            Swal.fire({
                    icon: 'error',
                    title: 'فشلت عملية الحذف .',
                    showConfirmButton: false,
                    timer: 1500

                  })
        }
    });
}

function storeWithValidation(url, data) {
    axios.post(url, data)
        .then(function(response) {
            Swal.fire({
                icon: response.data.icon,
                title: response.data.title,
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location = response.data.redirect;
            });
        })
        .catch(function(error) {
            if (error.response && error.response.data && error.response.data.errors) {
                let messages = Object.values(error.response.data.errors).flat().join('\n');
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: messages,
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong!',
                    text: 'Please try again.',
                });
            }
        });
}



function destroy(url, td) {
    axios.delete(url)
        .then(function (response) {
            console.log(response.data);
            if (td.closest('tr')) {
                td.closest('tr').remove();
            } else {
                td.closest('.card').remove();
            }
        })
        .catch(function (error) {
            console.log(error.response);
        });
}
function restoreAll() {
    Swal.fire({
        title: 'Restore All Tasks?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.isConfirmed) {
            let formData = new FormData();
            storeRoute('/dashboard/tasks/restore-all', formData);
        }
    });
}

function forceDeleteAll() {
    confirmDestroy('/dashboard/tasks/force-delete-all', document.querySelector('tbody'));
}




function showErrorMessages(errors) {

    document.getElementById('error_alert').hidden = false
    var errorMessagesUl = document.getElementById("error_messages_ul");
    errorMessagesUl.innerHTML = '';

    for (var key of Object.keys(errors)) {
        var newLI = document.createElement('li');
        newLI.appendChild(document.createTextNode(errors[key]));
        errorMessagesUl.appendChild(newLI);
    }
}

function clearAndHideErrors() {
    document.getElementById('error_alert').hidden = true
    var errorMessagesUl = document.getElementById("error_messages_ul");
    errorMessagesUl.innerHTML = '';
}

function clearForm() {
    document.getElementById("create_form").reset();
}

function showMessage(data) {
    console.log(data);
    Swal.fire({
        position: 'center',
        icon: data.icon,
        title: data.title,
        showConfirmButton: false,
        timer: 1500
    })
}

function addComment(taskId) {
    let input = document.getElementById('comment-input-' + taskId);
    let body = input.value;

    if (!body) return;

    axios.post('/dashboard/tasks/' + taskId + '/comments', { body: body })
        .then(function(response) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Comment Added!',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                input.value = '';
                location.reload();
            });
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: 'Failed to Add Comment!',
                showConfirmButton: false,
                timer: 1500
            });
        });
}

function deleteComment(id) {
    Swal.fire({
        title: 'Delete Comment?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete('/dashboard/comments/' + id)
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Comment Deleted!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        document.getElementById('comment-' + id).remove();
                    });
                });
        }
    });



}
function addCategory(url, formData) {
    axios.post(url, formData)
        .then(function(response) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Category Added!',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                location.reload();
            });
        })
        .catch(function(error) {
            if (error.response.data.errors) {
                let messages = Object.values(error.response.data.errors).flat().join('\n');
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: messages,
                });
            }
        });
}
