<div class="overflow-x-auto bg-surface rounded-xl border border-border p-4 hidden sm:block">
  <table class="min-w-full divide-y border-border text-xs">
    
    <thead class="bg-bg text-muted">
      <tr>
        <th class="px-3 py-2">ID</th>
        <th class="px-3 py-2 text-center">Barcode</th>
        <th class="px-3 py-2">No Polisi</th>
        <th class="px-3 py-2">Kendaraan</th>
        <th class="px-3 py-2">Tgl Masuk</th>
        <th class="px-3 py-2 text-center">Petugas Masuk</th>
        <th class="px-3 py-2">Tgl Keluar</th>
        <th class="px-3 py-2 text-center">Petugas Keluar</th>
        <th class="px-3 py-2 text-right">Total</th>
        <th class="px-3 py-2 text-center">Status</th>
      </tr>
    </thead>

    <tbody class="divide-y border-border text-text">
      <?php foreach ($listTiket as $tiket): ?>
        <tr class="transition hover-bg-primary">
          <td class="px-2 py-1"><?= $tiket['id_tiket'] ?></td>

          <td class="px-2 py-1">
            <?php
              $barcodeValue = $tiket['barcode'];
              $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
              $barcodeImage = $generator->getBarcode($barcodeValue, $generator::TYPE_CODE_128);
            ?>
            <div class="flex flex-col items-center">
              <img src="data:image/png;base64,<?= base64_encode($barcodeImage) ?>" class="w-36">
              <span class="tracking-[0.25em] text-xs mt-1 text-muted">
                <?= htmlspecialchars($barcodeValue) ?>
              </span>
            </div>
          </td>

          <td class="px-2 py-1"><?= $tiket['nomor_polisi'] ?></td>

          <?php
            $kendaraan = $tiket['jenis_kendaraan'] ?? '-';
            $kendaraanClass = match ($kendaraan) {
              'motor' => 'bg-soft-success',
              'mobil' => 'bg-soft-warning',
              default => 'bg-surface text-muted',
            };
          ?>
          <td class="px-2 py-1">
            <span class="px-2 py-0.5 rounded text-[11px] font-medium <?= $kendaraanClass ?>">
              <?= ucfirst($kendaraan) ?>
            </span>
          </td>

          <?php $dt = $tiket['tgl_masuk'] ? new DateTime($tiket['tgl_masuk']) : null; ?>
          <td class="px-2 py-1">
            <?php if ($dt): ?>
              <span class="relative group cursor-help">
                <?= $dt->format('d M Y') ?>
                <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1
                             hidden group-hover:block
                             bg-surface text-text text-[10px]
                             px-2 py-1 rounded shadow-primary">
                  <?= $dt->format('H:i') ?>
                </span>
              </span>
            <?php else: ?> - <?php endif; ?>
          </td>

          <td class="px-2 py-1 text-center">
            <span class="px-2 py-0.5 rounded bg-surface text-text text-[11px]">
              <?= $tiket['petugas_masuk'] ?? '-' ?>
            </span>
          </td>

          <?php $dt = $tiket['tgl_keluar'] ? new DateTime($tiket['tgl_keluar']) : null; ?>
          <td class="px-2 py-1">
            <?php if ($dt): ?>
              <span class="relative group cursor-help">
                <?= $dt->format('d M Y') ?>
                <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1
                             hidden group-hover:block
                             bg-surface text-text text-[10px]
                             px-2 py-1 rounded shadow-primary">
                  <?= $dt->format('H:i') ?>
                </span>
              </span>
            <?php else: ?>
              <span class="text-muted italic">Belum keluar</span>
            <?php endif; ?>
          </td>

          <td class="px-2 py-1 text-center">
            <span class="px-2 py-0.5 rounded bg-surface text-text text-[11px]">
              <?= $tiket['petugas_keluar'] ?? '-' ?>
            </span>
          </td>

          <td class="px-3 py-2 text-right font-semibold text-[11px]">
            Rp <?= number_format($tiket['total_harga'] ?? 0, 0, ',', '.') ?>
          </td>

          <?php
            $status = $tiket['status'] ?? '-';
            $statusClass = match ($status) {
              'masuk' => 'bg-soft-success',
              'keluar' => 'bg-soft-danger',
              default => 'bg-surface text-muted',
            };
          ?>
          <td class="px-2 py-1 text-center">
            <span class="px-2 py-0.5 rounded text-[11px] font-medium <?= $statusClass ?>">
              <?= ucfirst($status) ?>
            </span>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
