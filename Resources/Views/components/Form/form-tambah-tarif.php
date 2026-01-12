<form id="formTambahTarif"
      method="post"
      action="javascript:void(0)"
      class="space-y-4">

    <div class="space-y-1">
        <label class="block text-sm font-medium text-text">
            Jenis Kendaraan
        </label>

        <select
            name="jenis_kendaraan"
            required
            class="w-full px-4 py-2 rounded-xl
                   bg-bg border border-border
                   text-text
                   focus:outline-none focus:ring-2 focus:ring-primary/40">

            <option value="" disabled selected>
                Pilih kendaraan
            </option>
            <option value="motor">Motor</option>
            <option value="mobil">Mobil</option>
        </select>
    </div>

    <div class="space-y-1">
        <label class="block text-sm font-medium text-text">
            Harga Flat
        </label>

        <input
            type="number"
            name="harga_flat"
            required
            min="2000"
            max="100000"
            value="2000"
            placeholder="2000"
            class="w-full px-4 py-2 rounded-xl
                   bg-bg border border-border
                   text-text
                   focus:outline-none focus:ring-2 focus:ring-primary/40">

        <p class="text-xs text-muted">
            Minimal 2.000 · Maksimal 100.000
        </p>
    </div>

    <div class="pt-2">
        <button type="submit"
                class="w-full py-2.5 rounded-xl
                       bg-primary text-white font-medium
                       hover:opacity-90 active:scale-[0.98]
                       transition">
            Simpan
        </button>
    </div>

</form>
