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
        title: 'Delete This Tasks?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        cancelButtonText: 'Cancel',
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
    function performRestore(id, reference) {
        Swal.fire({
            title: 'Restore Task?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Yes, Restore!'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post('/dashboard/tasks/' + id + '/restore')
                    .then(function(response) {
                        showMessage(response.data);
                        reference.closest('tr').remove();
                    });
            }
        });
    }
    function destroyAll() {
        Swal.fire({
            title: 'Delete All Tasks?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete('/dashboard/tasks/destroy-all')
                    .then(function(response) {
                        showMessage(response.data);
                        setTimeout(() => location.reload(), 1500);
                    });
            }
        });
    }

        function toggleComments(taskId) {
        let row = document.getElementById('comments-' + taskId);
        row.style.display = row.style.display === 'none' ? '' : 'none';
    }

$('#search-input').on('keyup', function() {
    let value = $(this).val().toLowerCase();
    $("table tbody tr").filter(function() {
        // نتأكد من عدم إخفاء صفوف التعليقات بالخطأ
        if(!$(this).attr('id') || !$(this).attr('id').includes('comments')) {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        }
    });
});

function toggleTaskStatus(id, btn) {
    axios.post(`/dashboard/tasks/${id}/toggle-status`)
        .then(response => {
            if(response.data.success) {
                location.reload();
            }
        });
}

function toggleStar(id, icon) {
    axios.post(`/dashboard/tasks/${id}/toggle-star`)
        .then(response => {
            if (response.data.success) {
                if (response.data.is_starred) {
                    icon.classList.remove('far');
                    icon.classList.add('fas', 'text-warning');
                } else {
                    icon.classList.remove('fas', 'text-warning');
                    icon.classList.add('far');
                }
            }
        });
}
