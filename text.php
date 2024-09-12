<?php
include 'FontGroupController.php';
include 'fontController.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Dropbox UI using Bootstrap</title>

    <!-- Bootstrap 5 stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css" integrity="sha512-Ez0cGzNzHR1tYAv56860NLspgUGuQw16GiOOp/I2LuTmpSK9xDXlgJz3XN4cnpXWDmkNBKXR/VDMTCnAaEooxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- FontAwesome 6 stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .dropzone {
            border: dashed 4px #ddd !important;
            background-color: #f2f6fc;
            border-radius: 15px;
        }

        .dropzone .dropzone-container {
            padding: 2rem 0;
            width: 100%;
            height: 100%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #8c96a8;
            z-index: 20;
        }

        .dropzone .file-input {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            visibility: hidden;
            cursor: pointer;
        }

        .file-icon {
            font-size: 60px;
        }

        .hr-sect {
            display: flex;
            flex-basis: 100%;
            align-items: center;
            margin: 8px 0px;
        }

        .hr-sect:before,
        .hr-sect:after {
            content: "";
            flex-grow: 1;
            background: #ddd;
            height: 1px;
            font-size: 0px;
            line-height: 0px;
            margin: 0px 8px;
        }

        .dropzone.drag-over {
            border: 2px dashed #007bff;
            background-color: #f8f9fa;
        }

        .font-preview {
            font-size: 16px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container p-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 mt-5">
                <div class="bg-white p-5 rounded shadow-sm border">
                    <div id="dropzone" class="dropzone d-block">
                        <label for="files" class="dropzone-container">
                            <div class="file-icon"><i class="fa-solid fa-file-circle-plus text-primary"></i></div>
                            <div class="text-center pt-3 px-5">
                                <p class="w-80 h5 text-dark fw-bold">
                                    Click to upload or drag and drop <br> Only TTF File Allowed
                                </p>
                            </div>
                        </label>
                        <input id="files" name="files[]" type="file" class="file-input" accept=".ttf" multiple />
                    </div>

                    <!-- Table to display the uploaded fonts -->
                    <div class="container mt-4">
                        <table id="fontsTable" class="table table-striped mt-4">
                            <thead>
                                <tr>
                                    <th>Font Name</th>
                                    <th>Preview</th>
                                </tr>
                            </thead>
                            <tbody id="fontsTableBody">
                                <?php foreach ($fonts as $font): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($font['name']); ?></td>
                                        <td class="font-preview" style="font-family: '<?php echo htmlspecialchars($font['name']); ?>';">Sample Text</td>
                                        <td><strong style="cursor:pointer" class="text-danger delete-font" data-id="<?php echo htmlspecialchars($font['id']); ?>">DELETE</strong></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <form class="mb-4" id="fontGroupForm">
            <h3>Create Font Group</h3>
            <div id="fontRows">
                <div class="row font-row mb-3">
                    <div class="col-md-12">
                        <label for="groupTitle" class="form-label">Group Title</label>
                        <input type="text" class="form-control" id="groupTitle" name="group_title" placeholder="Group Title" required>
                    </div>
                    <div class="col-md-3">
                        <label for="fontName" class="form-label">Font Name</label>
                        <input type="text" class="form-control" id="fontName" name="font_name" placeholder="Font Name" required>
                    </div>
                    <div class="col-md-3">
                        <label for="fontSelect" class="form-label">Select Font</label>
                        <select id="fontsSelect" class="form-select" name="fonts[]">
                            <option value="">Select Font</option>
                            <?php foreach ($fonts as $font): ?>
                                <option value="<?php echo htmlspecialchars($font['id']); ?>">
                                    <?php echo htmlspecialchars($font['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="specificSize" class="form-label">Specific Size</label>
                        <input type="number" class="form-control" id="specificSize" name="specific_size" placeholder="Specific Size" step="0.1" min="0">
                    </div>
                    <div class="col-md-3">
                        <label for="priceChange" class="form-label">Price Change</label>
                        <input type="number" class="form-control" id="priceChange" name="price_change" placeholder="Price Change" step="0.01" min="0">
                    </div>
                    <i class="fa-solid fa-xmark remove-row" style="cursor: pointer; color: red; display: none;"></i>
                </div>
            </div>
            <button type="button" id="addRow" class="btn btn-primary mt-3">Add Row</button>
            <button type="submit" class="btn btn-success mt-3">Create Group</button>
        </form>
        <h3>Font Groups</h3>
        <table class="table table-bordered" id="fontGroupsTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Fonts</th>
                    <th>Count</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
        // Display existing font groups when the page is first loaded
        if (!empty($fontGroups)) {
            foreach ($fontGroups as $group) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($group['group_title']) . '</td>';
                echo '<td>' . htmlspecialchars($group['fonts']) . '</td>';
                echo '<td>' . htmlspecialchars($group['font_count']) . '</td>';
                echo '<td>';
                echo '<button class="btn btn-primary btn-sm edit-group" data-id="' . htmlspecialchars($group['id']) . '">Edit</button> ';
                echo '<a href="deleteFontGroup.php?id=' . $group['id'] . '" class="btn btn-danger btn-sm">Delete</a>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="4">No font groups available.</td></tr>';
        }
        ?>
            </tbody>
        </table>
         <!-- Modal for Editing Font Group -->
       <!-- Modal HTML -->
       <div class="modal fade" id="editFontGroupModal" tabindex="-1" aria-labelledby="editFontGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFontGroupModalLabel">Edit Font Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="mb-4" id="editFontGroupForm">
                        <input type="hidden" id="editGroupId" name="group_id">
                        <input type="hidden" id="formAction" value="edit">
                        <div class="mb-3">
                            <label class="form-label">Group Title</label>
                            <input type="text" class="form-control" id="editGroupTitle" name="group_title" required>
                        </div>
                        <div id="editFontRows">
                            <!-- Existing rows will be dynamically loaded here -->
                        </div>
                        <button type="button" id="addEditRow" class="btn btn-primary mt-3">Add Row</button>
                        <button type="submit" class="btn btn-success mt-3">Update Group</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    var dropzone = $('#dropzone');

    // Prevent default drag behaviors
    $(document).on('dragover dragenter', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    // Highlight dropzone when dragging files over it
    dropzone.on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropzone.addClass('drag-over');
    });

    // Remove highlight when dragging leaves the dropzone
    dropzone.on('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropzone.removeClass('drag-over');
    });

    // Handle drop event
    dropzone.on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropzone.removeClass('drag-over');

        var files = e.originalEvent.dataTransfer.files;
        handleFileUpload(files);
    });

    // Handle click-to-upload
    $('#files').on('change', function() {
        handleFileUpload(this.files);
    });

    // Function to handle file upload
    function handleFileUpload(files) {
        var formData = new FormData();
        $.each(files, function(i, file) {
            formData.append('files[]', file);
        });

        $.ajax({
            url: 'fontController.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var result = JSON.parse(response);                
                updateFontsTable(result);
                updateFontDropdown(result[0].fonts);
                addNewRow(result[0].fonts);
                alert('Files uploaded successfully!');
            },
            error: function() {
                alert('Failed to upload files.');
            }
        });
    }
    function updateFontDropdown(fonts) {
        
        console.log(fonts);
        var select = $('#fontsSelect'); // Use the ID of the select element
        select.empty(); // Clear existing options
        select.append('<option value="">Select Font</option>'); // Default option

        $.each(fonts, function(index, font) {
            select.append(`<option value="${font.id}">${font.name}</option>`);
        });
    }

    // Function to update the fonts table
    function updateFontsTable(result) {
        var tableBody = $('#fontsTableBody');

        $.each(result, function(index, item) {
            if (item.status === "success") {
                var fontUrl = 'uploads/' + item.file;
                var row = `<tr>
                    <td>${item.font_name}</td>
                    <td class="font-preview" style="font-family: '${item.font_name}'; font-size: 16px; color: #333;">Sample Text</td>
                    <td><strong class="text-danger delete-font" data-id="${item.id}">DELETE</strong></td>
                </tr>`;
                
                // Dynamically create a style element to load the font
                var style = `<style>
                    @font-face {
                        font-family: '${item.font_name}';
                        src: url('${fontUrl}') format('truetype');
                    }
                </style>`;
                $('head').append(style);

                // Insert new rows at the top of the table
                tableBody.prepend(row);
            } else {
                console.log(item.message); // Handle error messages if needed
            }
        });
    }

    // Handle font deletion
    $(document).on('click', '.delete-font', function() {
        var button = $(this);
        var fontId = button.data('id');
       
        $.ajax({
            url: 'fontController.php',
            type: 'POST',
            data: { delete_id: fontId },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === "success") {
                    button.closest('tr').remove();
                    alert('Font deleted successfully!');
                } else {
                    alert('Failed to delete font.');
                }
            },
            error: function() {
                alert('Failed to delete font.');
            }
        });
    });

    // Initialize fonts preview on page load
    <?php foreach ($fonts as $font): ?>
        var fontName = '<?php echo htmlspecialchars($font['name']); ?>';
        var fontUrl = 'uploads/<?php echo htmlspecialchars($font['file_name']); ?>';
        var style = `
            @font-face {
                font-family: '${fontName}';
                src: url('${fontUrl}') format('truetype');
            }
        `;
        $('<style>').prop('type', 'text/css').html(style).appendTo('head');

        // Apply font to the preview column only
        $('#fontsTableBody').find(`td[style*="${fontName}"]`).css('font-family', fontName);
    <?php endforeach; ?>
});
</script>
<script>
    $(document).ready(function() {
        // Handle form submission
        $('#fontGroupForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            var rowCount = $('.font-row').length;
            if (rowCount < 2) {
                alert("Please add at least two font rows to create a group.");
                return; // Stop form submission
            }

            var formData = $(this).serialize(); // Serialize all form data
            formData += '&action=create'; // Add action parameter to identify the request type

            $.ajax({
                url: 'FontGroupController.php', // PHP file to handle the form submission
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#fontGroupsTable tbody').html(response); // Update table with new data
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error); // Handle errors
                }
            });
        });

        // Add new row logic
        $('#addRow').on('click', function() {
            var newRow = `
                <div class="row font-row mb-3">
                     <div class="col-md-3">
                        <label for="fontName" class="form-label">Font Name</label>
                        <input type="text" class="form-control" name="font_name[]" placeholder="Font Name" required>
                    </div>
                    <div class="col-md-3">
                        <label for="fontSelect" class="form-label">Select Font</label>
                        <select id="fontsSelect" class="form-select" name="fonts[]">
                            <option value="">Select Font</option>
                            <?php foreach ($fonts as $font): ?>
                                <option value="<?php echo htmlspecialchars($font['id']); ?>">
                                    <?php echo htmlspecialchars($font['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="specificSize" class="form-label">Specific Size</label>
                        <input type="number" class="form-control" name="specific_size[]" placeholder="Specific Size" step="0.1" min="0">
                    </div>
                    <div class="col-md-3">
                        <label for="priceChange" class="form-label">Price Change</label>
                        <input type="number" class="form-control" name="price_change[]" placeholder="Price Change" step="0.01" min="0">
                    </div>
                    <i class="fa-solid fa-xmark remove-row" style="cursor: pointer; color: red;"></i>
                </div>
            `;
            $('#fontRows').append(newRow); // Append new row to the form
        });

        // Remove row logic
        $('#fontRows').on('click', '.remove-row', function() {
            $(this).closest('.font-row').remove(); // Remove the selected row
        });
    });
</script>

<script>
// Open the edit modal and populate it with data
$('#fontGroupsTable').on('click', '.edit-group', function() {
    const groupId = $(this).data('id');
    $.ajax({
        url: 'FontGroupController.php',
        method: 'GET',
        data: { id: groupId },
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                alert(response.error);
                return;
            }

            const group = response;

            // Clear existing rows
            $('#editFontRows').empty();

            // Populate form fields
            $('#editGroupTitle').val(group.group_title);

            // Check if 'fonts' is an array
            if (Array.isArray(group.fonts)) {
                group.fonts.forEach(function(font, index) {
                    const fontRow = `
                        <div class="row font-row mb-3">                           
                            <div class="col-md-3">
                                <label class="form-label">Font Name</label>
                                <input type="text" class="form-control" name="font_name[]" value="${font.name}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Select Font</label>
                                <select class="form-select" name="fonts[]">
                                    <option value="">Select Font</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Specific Size</label>
                                <input type="number" class="form-control" name="specific_size[]" value="${font.specific_size}" step="0.1" min="0">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Price Change</label>
                                <input type="number" class="form-control" name="price_change[]" value="${font.price_change}" step="0.01" min="0">
                            </div>
                            <i class="fa-solid fa-xmark remove-row" style="cursor: pointer; color: red;"></i>
                        </div>
                    `;
                    $('#editFontRows').append(fontRow);
                });

                // Populate font select options
                $.ajax({
                    url: 'FontGroupController.php', // Replace with your PHP file that returns font options
                    method: 'GET',
                    dataType: 'json',
                    success: function(fonts) {
                        $('#editFontRows .font-row').each(function() {
                            const select = $(this).find('select[name="fonts[]"]');
                            fonts.forEach(function(fontOption) {
                                const option = `<option value="${fontOption.id}">${fontOption.name}</option>`;
                                select.append(option);
                            });
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ', status, error);
                    }
                });
            } else {
                console.error('Fonts data is not an array:', group.fonts);
            }

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('editFontGroupModal'));
            modal.show();
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ', status, error);
        }
    });

    // Add row to the edit form
    $('#addEditRow').click(function() {
        const newRow = `
            <div class="row font-row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Group Title</label>
                    <input type="text" class="form-control" name="group_title" placeholder="Group Title" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Font Name</label>
                    <input type="text" class="form-control" name="font_name[]" placeholder="Font Name" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Select Font</label>
                    <select class="form-select" name="fonts[]">
                        <option value="">Select Font</option>
                        <!-- Options will be populated dynamically -->
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Specific Size</label>
                    <input type="number" class="form-control" name="specific_size[]" placeholder="Specific Size" step="0.1" min="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Price Change</label>
                    <input type="number" class="form-control" name="price_change[]" placeholder="Price Change" step="0.01" min="0">
                </div>
                <i class="fa-solid fa-xmark remove-row" style="cursor: pointer; color: red;"></i>
            </div>
        `;
        $('#editFontRows').append(newRow);

        // Populate font select options for new row
        $.ajax({
            url: 'FontOptionsController.php', // Replace with your PHP file that returns font options
            method: 'GET',
            dataType: 'json',
            success: function(fonts) {
                const select = $('#editFontRows .font-row').last().find('select[name="fonts[]"]');
                fonts.forEach(function(fontOption) {
                    const option = `<option value="${fontOption.id}">${fontOption.name}</option>`;
                    select.append(option);
                });
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ', status, error);
            }
        });
    });

    // Remove row from the edit form
    $('#editFontRows').on('click', '.remove-row', function() {
        $(this).closest('.font-row').remove();
    });

    // Handle form submission for editing
    $('#editFontGroupForm').submit(function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize() + '&action=update';
        
        $.ajax({
            url: 'FontGroupController.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                const result = JSON.parse(response);
                if (result.success) {
                    alert(result.success);
                    $('#editFontGroupModal').modal('hide');
                    location.reload(); // Reload the page to show updated data
                } else {
                    alert('Update failed: ' + result.error);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });
});
</script>

</html>
