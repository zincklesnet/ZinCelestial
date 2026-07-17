<?php if ( ! defined( 'ABSPATH' ) ) exit;
$tickets = get_site_option( 'zc_helpdesk_tickets', [] );
krsort( $tickets ); // Newest first
?>
<div class="wrap zca-wrap">
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="zca-page-title mb-0"><i class="bi bi-headset me-2"></i><?php esc_html_e( 'Help Desk', 'zincelestial' ); ?></h1>
  <button class="btn btn-primary" id="zcaOpenNewTicket">
    <i class="bi bi-plus-circle me-1"></i><?php esc_html_e( 'New Ticket', 'zincelestial' ); ?>
  </button>
</div>

<!-- ── Stats row ── -->
<?php
$all    = count( $tickets );
$open   = count( array_filter( $tickets, fn($t) => ($t['status']??'open') === 'open' ) );
$inprog = count( array_filter( $tickets, fn($t) => ($t['status']??'') === 'in-progress' ) );
$resolved=count( array_filter( $tickets, fn($t) => ($t['status']??'') === 'resolved' ) );
?>
<div class="row g-3 mb-4">
  <?php foreach ( [
    [ 'All',        $all,      'bi-ticket-fill',     'primary'  ],
    [ 'Open',       $open,     'bi-exclamation-circle-fill','danger' ],
    [ 'In Progress',$inprog,   'bi-hourglass-split', 'warning'  ],
    [ 'Resolved',   $resolved, 'bi-check-circle-fill','success' ],
  ] as [$label,$count,$icon,$cls] ): ?>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 text-center py-3">
      <i class="bi <?php echo $icon; ?> text-<?php echo $cls; ?> fs-2 mb-1"></i>
      <div class="fw-bold fs-4"><?php echo $count; ?></div>
      <div class="text-muted small"><?php echo $label; ?></div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<!-- ── Status filter pills ── -->
<ul class="nav nav-pills mb-3" id="zcaTicketTabs">
  <li class="nav-item"><button class="nav-link active" data-filter="all"><?php esc_html_e( 'All', 'zincelestial' ); ?></button></li>
  <li class="nav-item"><button class="nav-link" data-filter="open"><?php esc_html_e( 'Open', 'zincelestial' ); ?></button></li>
  <li class="nav-item"><button class="nav-link" data-filter="in-progress"><?php esc_html_e( 'In Progress', 'zincelestial' ); ?></button></li>
  <li class="nav-item"><button class="nav-link" data-filter="resolved"><?php esc_html_e( 'Resolved', 'zincelestial' ); ?></button></li>
</ul>

<!-- ── Ticket table ── -->
<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover mb-0 align-middle">
      <thead class="table-dark">
        <tr>
          <th><?php esc_html_e( 'Ticket ID', 'zincelestial' ); ?></th>
          <th><?php esc_html_e( 'Subject', 'zincelestial' ); ?></th>
          <th><?php esc_html_e( 'User', 'zincelestial' ); ?></th>
          <th><?php esc_html_e( 'Status', 'zincelestial' ); ?></th>
          <th><?php esc_html_e( 'Priority', 'zincelestial' ); ?></th>
          <th><?php esc_html_e( 'Site', 'zincelestial' ); ?></th>
          <th><?php esc_html_e( 'Created', 'zincelestial' ); ?></th>
          <th><?php esc_html_e( 'Actions', 'zincelestial' ); ?></th>
        </tr>
      </thead>
      <tbody id="zcaTicketTableBody">
        <?php if ( empty( $tickets ) ): ?>
        <tr><td colspan="8" class="text-center text-muted py-5">
          <i class="bi bi-inbox display-5 d-block mb-2"></i>
          <?php esc_html_e( 'No tickets yet. Create your first support ticket!', 'zincelestial' ); ?>
        </td></tr>
        <?php else:
        foreach ( $tickets as $tid => $t ):
          $status   = $t['status']   ?? 'open';
          $priority = $t['priority'] ?? 'low';
          $scls = [ 'open' => 'danger', 'in-progress' => 'warning', 'resolved' => 'success' ][ $status ] ?? 'secondary';
          $pcls = [ 'high' => 'danger', 'medium' => 'warning', 'low' => 'secondary' ][ $priority ] ?? 'secondary';
          $bid  = $t['blog_id'] ?? 1;
          $site_name = is_multisite() ? get_blog_details( $bid )->blogname ?? "Site {$bid}" : get_bloginfo('name');
        ?>
        <tr data-status="<?php echo esc_attr( $status ); ?>" data-ticket-id="<?php echo esc_attr( $tid ); ?>">
          <td><code class="text-primary fw-semibold"><?php echo esc_html( $tid ); ?></code></td>
          <td class="fw-semibold"><?php echo esc_html( $t['subject'] ?? '—' ); ?></td>
          <td><small><?php echo esc_html( $t['user_name'] ?? '—' ); ?></small></td>
          <td><span class="badge bg-<?php echo $scls; ?> text-uppercase"><?php echo esc_html( $status ); ?></span></td>
          <td><span class="badge bg-<?php echo $pcls; ?>"><?php echo esc_html( $priority ); ?></span></td>
          <td><small class="text-muted"><?php echo esc_html( $site_name ); ?></small></td>
          <td><small class="text-muted"><?php echo esc_html( date( 'M j, Y', strtotime( $t['created'] ?? 'now' ) ) ); ?></small></td>
          <td>
            <button class="btn btn-sm btn-outline-primary zca-view-ticket me-1"
                    data-ticket='<?php echo esc_attr( wp_json_encode( $t ) ); ?>'
                    data-ticket-id="<?php echo esc_attr( $tid ); ?>">
              <i class="bi bi-eye"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger zca-delete-ticket"
                    data-ticket-id="<?php echo esc_attr( $tid ); ?>">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ══════════════════════════════════════════
     NEW TICKET MODAL
══════════════════════════════════════════ -->
<div class="modal fade" id="zcaNewTicketModal" tabindex="-1" aria-labelledby="zcaNewTicketLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="zcaNewTicketLabel">
          <i class="bi bi-plus-circle me-2"></i><?php esc_html_e( 'Create New Support Ticket', 'zincelestial' ); ?>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div id="zcaTicketAlert" class="alert d-none" role="alert"></div>
        <form id="zcaNewTicketForm" autocomplete="off">
          <?php wp_nonce_field( 'zc_new_ticket', 'zc_ticket_nonce' ); ?>
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label fw-semibold"><?php esc_html_e( 'Subject', 'zincelestial' ); ?> <span class="text-danger">*</span></label>
              <input type="text" name="subject" class="form-control form-control-lg" placeholder="Brief description of your issue" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold"><?php esc_html_e( 'Priority', 'zincelestial' ); ?></label>
              <select name="priority" class="form-select">
                <option value="low">🟢 Low</option>
                <option value="medium" selected>🟡 Medium</option>
                <option value="high">🔴 High</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold"><?php esc_html_e( 'Category', 'zincelestial' ); ?></label>
              <select name="category" class="form-select">
                <option value="general">General</option>
                <option value="technical">Technical Issue</option>
                <option value="billing">Billing</option>
                <option value="feature">Feature Request</option>
                <option value="bug">Bug Report</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold"><?php esc_html_e( 'Description', 'zincelestial' ); ?></label>
              <textarea name="description" class="form-control" rows="5"
                        placeholder="Describe your issue in detail..."></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal"><?php esc_html_e( 'Cancel', 'zincelestial' ); ?></button>
        <button class="btn btn-primary" id="zcaSubmitTicket">
          <span class="spinner-border spinner-border-sm d-none me-2" id="zcaTicketSpinner"></span>
          <i class="bi bi-send me-1" id="zcaSubmitIcon"></i><?php esc_html_e( 'Submit Ticket', 'zincelestial' ); ?>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ══ VIEW TICKET MODAL ══ -->
<div class="modal fade" id="zcaViewTicketModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-ticket-detailed me-2"></i>Ticket Details: <code id="zcaViewTicketId"></code></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="zcaViewTicketBody"><!-- filled by JS --></div>
      <div class="modal-footer">
        <div class="d-flex gap-2 me-auto">
          <select id="zcaTicketStatusSelect" class="form-select form-select-sm" style="width:auto;">
            <option value="open">Open</option>
            <option value="in-progress">In Progress</option>
            <option value="resolved">Resolved</option>
            <option value="closed">Closed</option>
          </select>
          <button class="btn btn-sm btn-outline-primary" id="zcaSaveTicketStatus">Save Status</button>
        </div>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
(function($){
  'use strict';
  const ajaxUrl = ZC_Admin.ajax_url;
  const nonce   = ZC_Admin.nonce;
  let currentTicketId = '';

  // ── Open new ticket modal via dedicated button ──
  document.getElementById('zcaOpenNewTicket').addEventListener('click', function(){
    var modal = new bootstrap.Modal(document.getElementById('zcaNewTicketModal'));
    modal.show();
  });

  // ── Filter tabs ──
  $('#zcaTicketTabs .nav-link').on('click', function(){
    $('#zcaTicketTabs .nav-link').removeClass('active');
    $(this).addClass('active');
    const f = $(this).data('filter');
    $('#zcaTicketTableBody tr').each(function(){
      if(f === 'all' || $(this).data('status') === f){
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });

  // ── Submit ticket ──
  $('#zcaSubmitTicket').on('click', function(){
    const form = $('#zcaNewTicketForm')[0];
    if(!form.checkValidity()){ form.reportValidity(); return; }
    const btn  = $(this);
    const spin = $('#zcaTicketSpinner');
    const icon = $('#zcaSubmitIcon');
    btn.prop('disabled', true);
    spin.removeClass('d-none');
    icon.addClass('d-none');
    const formData = new FormData(form);
    formData.append('action', 'zc_new_ticket');
    $.ajax({
      url: ajaxUrl,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(r){
        const al = $('#zcaTicketAlert');
        if(r.success){
          al.removeClass('d-none alert-danger').addClass('alert-success')
            .html('<i class="bi bi-check-circle me-2"></i><strong>Ticket created!</strong> ID: <strong>' + r.data.ticket_id + '</strong>. Page will reload…');
          setTimeout(function(){ window.location.reload(); }, 1800);
        } else {
          al.removeClass('d-none alert-success').addClass('alert-danger')
            .html('<i class="bi bi-x-circle me-2"></i>' + (r.data || 'Unknown error'));
          btn.prop('disabled', false);
          spin.addClass('d-none');
          icon.removeClass('d-none');
        }
      },
      error: function(){
        $('#zcaTicketAlert').removeClass('d-none').addClass('alert-danger').text('Server error. Please try again.');
        btn.prop('disabled', false);
        spin.addClass('d-none');
        icon.removeClass('d-none');
      }
    });
  });

  // ── View ticket ──
  $(document).on('click', '.zca-view-ticket', function(){
    const t  = $(this).data('ticket');
    const tid= $(this).data('ticket-id');
    currentTicketId = tid;
    $('#zcaViewTicketId').text(tid);
    $('#zcaTicketStatusSelect').val(t.status || 'open');
    let replies = '';
    if(t.replies && t.replies.length){
      t.replies.forEach(function(r){
        replies += '<div class="border-start border-primary ps-3 mb-3"><small class="text-muted">'+r.author+' · '+r.date+'</small><p class="mb-0">'+r.message+'</p></div>';
      });
    } else {
      replies = '<p class="text-muted">No replies yet.</p>';
    }
    const scls = {open:'danger','in-progress':'warning',resolved:'success',closed:'secondary'}[t.status]||'secondary';
    const pcls = {high:'danger',medium:'warning',low:'secondary'}[t.priority]||'secondary';
    $('#zcaViewTicketBody').html(
      '<div class="row g-3">'+
      '<div class="col-md-8"><h6 class="text-muted text-uppercase small mb-1">Subject</h6><h5>'+t.subject+'</h5>'+
      '<h6 class="text-muted text-uppercase small mt-3 mb-1">Description</h6>'+
      '<p>'+(t.description||'No description provided.')+'</p>'+
      '<h6 class="text-muted text-uppercase small mt-3 mb-2">Replies</h6>'+replies+'</div>'+
      '<div class="col-md-4"><div class="card card-body bg-light border-0">'+
      '<p><strong>Ticket ID</strong><br><code>'+tid+'</code></p>'+
      '<p><strong>Status</strong><br><span class="badge bg-'+scls+'">'+t.status+'</span></p>'+
      '<p><strong>Priority</strong><br><span class="badge bg-'+pcls+'">'+t.priority+'</span></p>'+
      '<p><strong>Category</strong><br>'+(t.category||'General')+'</p>'+
      '<p><strong>Submitted By</strong><br>'+(t.user_name||'—')+'</p>'+
      '<p><strong>Email</strong><br>'+(t.user_email||'—')+'</p>'+
      '<p class="mb-0"><strong>Created</strong><br>'+t.created+'</p>'+
      '</div></div></div>'
    );
    new bootstrap.Modal(document.getElementById('zcaViewTicketModal')).show();
  });

  // ── Save ticket status ──
  $('#zcaSaveTicketStatus').on('click', function(){
    if(!currentTicketId) return;
    $.post(ajaxUrl, {
      action: 'zc_update_ticket',
      nonce: nonce,
      ticket_id: currentTicketId,
      status: $('#zcaTicketStatusSelect').val()
    }, function(r){
      if(r.success){
        $('[data-ticket-id="'+currentTicketId+'"]').attr('data-status', $('#zcaTicketStatusSelect').val());
        setTimeout(function(){ window.location.reload(); }, 800);
      }
    });
  });

  // ── Delete ticket ──
  $(document).on('click', '.zca-delete-ticket', function(){
    const tid = $(this).data('ticket-id');
    if(!confirm('Delete ticket ' + tid + '? This cannot be undone.')) return;
    $.post(ajaxUrl, { action: 'zc_delete_ticket', nonce: nonce, ticket_id: tid }, function(r){
      if(r.success){ $('[data-ticket-id="'+tid+'"]').fadeOut(400, function(){ $(this).remove(); }); }
    });
  });

})(jQuery);
</script>
</div><!-- .wrap -->
