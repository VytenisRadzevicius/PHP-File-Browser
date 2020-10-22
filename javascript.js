var root = 'www'; // Root directory for configuration

$('#dirmodal').on('show.bs.modal', function () {
  $('#modalAlert').hide();
  $('#modalAlert').empty();
  $('#folder').val('');
  $('#foldersubmit').prop('disabled', true);
});

$("#folderform").submit(function(e){
  e.preventDefault();

  let folder = $("#folder").val();
  if (/^[A-Za-z0-9]+$/.test(folder)) {

    $.ajax({
      type: "POST",
      url: "ajax.php",
      dataType: "JSON",
      cache: false,
      data: { 'action': 'create', 'item': folder, 'path': getPath() }
    }).done(function(json) {
      $('#modalAlert').show();
      switch(json['type']) {
        case 'success':
          $('#modalAlert').html('Folder <b>'+ json['name'] +'</b> has been created successfuly!');
          load('folder', getPath())
          break;
  
        case 'error':
          $('#modalAlert').html('Error! Directory already exists.');
          break;
      }
    });
  }
});

$('#folder').on('change input',function(e){
  let folder = $("#folder").val();
  if (!/^[A-Za-z0-9]+$/.test(folder)) $('#foldersubmit').prop('disabled', true); else $('#foldersubmit').prop('disabled', false);
 });

var table = $('#table').DataTable({ // Initialize DataTable
  language: {
    search: "_INPUT_",
    searchPlaceholder: "Search...",
    zeroRecords: "",
    emptyTable: ""
  },
  "paging":   false,
  "info":     false,
  "columnDefs": [
        
      { "className": "small text-truncate", "targets": [1, 2] },
      { "className": "text-center text-truncate", "targets": [3] }
  ],
    "order": [[ 3, "asc" ]]
});

function getPath() { // Get path from HTML
  return $('[name="path"]').val();
}

function load(a, p) { // Get directory data using AJAX
  if(a == 'folder') {
    
    let last = p.split("\\").slice(0, -1);
    let pos = last.indexOf(root);
    $('#back').off('click');
    if(pos > 0) {
      $('#back').fadeIn();
      $('#back').html("<i class='fas fa-reply-all'></i> Back to " + last.pop());
      $('#back').on('click', function () {
        load('folder', p.split("\\").slice(0, -1).join("\\"));
      });
    } else {
      $('#back').fadeOut();
    }
    $('[name="path"]').val(p);
  }
  
  $.ajax({
    type: "POST",
    url: "ajax.php",
    dataType: "JSON",
    cache: false,
    data: { 'action': a, 'path': p }
  }).done(function(json) {

    switch(json['type']) {
      case 'folder':
        populateTable(json);
        break;

      case 'text':
        populateModal(json);
        break;

      case 'image':
        populateModal(json);
        break;

      case 'empty':
        populateTable(json);
        break;
    }
  });
}

load('folder', getPath()); // Initial load of files and directories

function initTooltip() { // Initialize tooltip
    $(".tooltip").tooltip("hide");
    $('[data-toggle="tooltip"]').tooltip({
      trigger : 'hover'
    });
}

function breadcrumb() { // Breadcrumb directories
  let p = getPath().split('\\');
  let poswww = p.indexOf(root);
  let i = 0;

  $('#breadcrumb').empty();
  
  p.forEach(function(e) {
    i++;
    let pp = getPath().split(e);
    let r = Math.random().toString(36).substring(7);
    let d = '';
    (i <= poswww) ? d = ' data-toggle="tooltip" title="Access denied"' : d =  ' id="' + r + '"';
    let bc = '<li class="breadcrumb-item"><a href="javascript: void(0);"' + d + '>' + e + '</a></li>';
    $('#breadcrumb').append(bc);
    $("#" + r).click(function() {
      load('folder', pp[0] + e);
    });
    initTooltip();
  });
  
  $('#breadcrumb').append('<li class="breadcrumb-item">..</li>');
}

function populateTable(j) { // Populate the table with files and directories
  breadcrumb();
  table.clear();
  
  j.data.forEach(e => {

    let r = Math.random().toString(36).substring(7);
    let type = e[0];
    let name = e[1];

    if(j.type != 'empty') {
      e[1] = "<i class='far align-middle fa-" + type + "'></i> <button type='button' id='" + r + "' class='btn p-0 border-0 btn-link'>" + name + "</button>";
      if(e[3]) e[3] = formatBytes(e[3]);
      let p = getPath().replace(/\\/g, "/")
      if(e[4]) e[4] = "<a href='http://localhost" + p.split(root)[1] + "/" + name + "' data-toggle='tooltip' title='Open' class='btn btn-outline-secondary btn-sm py-0'><small><i class='fas fa-long-arrow-alt-right'></i></small></a>";
      
      e.shift();
    } else {
      e[0] = "Directory is empty.";
    }

    // add and animate rows
    var rowNode = table.row.add(e).draw().node();
    $(rowNode).css( 'opacity', '0' ).animate( { opacity: '1' }, 600 );

    $("#" + r).click(function() { // add event listener
      load(type, getPath() + "\\" + name);
    });

    initTooltip();
  });
}

function populateModal(j) { // Populate modal with file contents
  $('#modalHeader').text(j.name);
  if(j.type == 'text') { // text
    let l = j.data[0].split('\n');
    for(i = 0; i < l.length; i++) {
      l[i] = "<div class='d-block'><small class='text-muted'>" + (i + 1) + ".</small> " + l[i] + "</div>";
    }
    j.data[0] = "<pre class='stripes d-inline-block'>" + l.join('') + "</pre>";
  }
  else if(j.type == 'image') { // image
    let l = j.data[0].split(root);
    l = l[1].replace(/\\/g, "/")
    j.data = "<div class='container-fluid text-center'><img class='img-fluid' src='http://localhost" + l + "'></div>";
  }

  $('#modalBody').html(j.data);
  $('#modal').modal('show').trigger('focus');
  
  $('#modal').on('shown.bs.modal', function () { // Reset modal scrollbar
    $("#modalBody").animate({ scrollLeft: 0 }, 'slow');
  })
}


function formatBytes(size, precision = 2) { // File size format
  let base = Math.log(size) / Math.log(1024);
  let suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];   

  return Number(Math.pow(1024, base - Math.floor(base))).toFixed(precision) + " " + suffixes[Math.floor(base)];
}