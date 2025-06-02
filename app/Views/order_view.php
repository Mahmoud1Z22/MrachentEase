<!-- START SECTION ORDER -->
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>My Orders</h2>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?php echo session()->getFlashdata('success'); ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <?php if (empty($orders)): ?>
                    <p class="text-center">You have no orders yet.</p>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5>Order #<?php echo $order['order_id']; ?> - <?php echo date('F j, Y, g:i a', strtotime($order['order_date'])); ?></h5>
                                <span class="badge badge-<?php echo $order['status'] === 'pending' ? 'warning' : ($order['status'] === 'processing' ? 'info' : ($order['status'] === 'shipped' ? 'primary' : ($order['status'] === 'delivered' ? 'success' : 'danger'))); ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                                <span class="float-right">Total: $<?php echo number_format($order['total_amount'], 2); ?></span>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($order['suborders'])): ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Suborder ID</th>
                                                <th>Shop</th>
                                                <th>Subtotal</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($order['suborders'] as $suborder): ?>
                                                <tr>
                                                    <td><?php echo $suborder['suborder_id']; ?></td>
                                                    <td><?php echo $shopNames[$suborder['shop_id']] ?? 'Unknown Shop'; ?></td>
                                                    <td>$<?php echo number_format($suborder['subtotal'], 2); ?></td>
                                                    <td>
                                                        <span class="badge badge-<?php echo $suborder['suborder_status'] === 'pending' ? 'warning' : ($suborder['suborder_status'] === 'processing' ? 'info' : ($suborder['suborder_status'] === 'shipped' ? 'primary' : ($suborder['suborder_status'] === 'delivered' ? 'success' : 'danger'))); ?>">
                                                            <?php echo ucfirst($suborder['suborder_status']); ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p class="text-muted">No suborders available for this order.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION ORDER -->