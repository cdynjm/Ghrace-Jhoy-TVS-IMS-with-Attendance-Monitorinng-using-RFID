var SweetAlert = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-primary btn-sm',
        cancelButton: 'btn btn-secondary btn-sm ms-2'
    },
    buttonsStyling: false
});

function loadAcademicYear(course) {
    // Function to load subjects based on selected school year and semester
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + $('meta[name="token"]').attr('content');
    axios.get('/api/search/get-school-year', {
        params: {
            course: course
        }
    })
    .then(function(response) {
        // Clear current options
        $('#school-year').empty().append('<option value="">Select Academic Year</option>');
        // Populate subjects
        response.data.Years.forEach(function(year) {
            $('#school-year').append('<option value="' + year.schoolYear + '">' + year.schoolYear + '</option>');
        });
    })
    .catch(function(error) {
        console.error(error);
    });
}

// Function to load sections based on selected school year and semester
function loadSemester(course) {
    // Function to load subjects based on selected school year and semester
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + $('meta[name="token"]').attr('content');
    axios.get('/api/search/get-year-semester', {
        params: {
            course: course
        }
    })
    .then(function(response) {
        // Clear current options
        $('#year-semester').empty().append('<option value="">Select Year & Semester</option>');
        // Populate sections
        response.data.semesters.forEach(function(sem) {
            $('#year-semester').append('<option value="' + sem.id + '">' + sem.yearLevel + ' - '  + sem.semester + '</option>');
        });
    })
    .catch(function(error) {
        console.error(error);
    });
}

// Event listener for school year and semester change
$(document).on('change', '#course-change', function() {
    var course = $(this).val();
    // Check if both fields have values
    if (course) {
        loadAcademicYear(course);
        loadSemester(course);
    } else {
        // Clear options if one of the fields is not selected
        $('#school-year').empty().append('<option value="">Select Academic Year</option>');
        $('#year-semester').empty().append('<option value="">Select Year & Semester</option>');
    }
});

$(document).on('submit', "#search-grades-instructor", function(e){
    e.preventDefault();
    const formData = new FormData(this);
    async function APIrequest() {
        return await axios.post('/api/search/grades-instructor', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#grades-data-instructor').html(response.data.Grades);
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('keyup', '#search-input', function() {
    var searchTerm = $(this).val().toLowerCase().replace(/^\s+|\s+$/g, ''); // Remove leading/trailing spaces only
    var noResults = true;

    // Filter through each row in the tbody except those with the 'exclude-from-search' class
    $('#students-data tbody tr').not('.exclude-from-search').each(function() {
        var rowText = $(this).text().toLowerCase();

        // Check if row contains the search term
        if (rowText.includes(searchTerm)) {
            $(this).show();  // Show rows that match the search term
            noResults = false; // At least one row matches
        } else {
            $(this).hide();  // Hide rows that don’t match
        }
    });

    // Show 'No data found' message if no rows match
    if (noResults) {
        $('#students-data tbody').append('<tr class="no-data"><td colspan="7" class="text-center">No data found</td></tr>');
    } else {
        $('#students-data tbody .no-data').remove(); // Remove 'No data found' message if there are matching rows
    }
});