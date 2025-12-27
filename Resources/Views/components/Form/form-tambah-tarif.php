<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tarif Parkir</title>
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
          integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body class="bg-gradient-to-r from-slate-900 to-slate-800 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-slate-800 p-6 rounded-2xl shadow-2xl">
        <h2 class="text-3xl font-bold text-cyan-400 mb-6 text-center">Tambah Tarif Parkir</h2>

        <form action="?action=store-tambah-tarif" method="POST" class="space-y-5">

            <div>
                <label class="block text-slate-300 mb-2 font-medium" for="jenis_kendaraan">Jenis Kendaraan</label>
                <select name="jenis_kendaraan" id="jenis_kendaraan" class="w-full p-3 rounded-lg bg-slate-900 text-slate-300 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    <option value="">-- Pilih Jenis Kendaraan --</option>
                    <option value="mobil">Mobil</option>
                    <option value="motor">Motor</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-300 mb-2 font-medium" for="harga_flat">Harga Flat</label>
                <input type="number" name="harga_flat" id="harga_flat" placeholder="Masukkan harga flat" required
                       class="w-full p-3 rounded-lg bg-slate-900 text-slate-300 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>

            <div class="flex gap-4 justify-between mt-4">
                <button type="submit"
                        class="flex-1 bg-cyan-500 hover:bg-cyan-600 text-slate-900 px-4 py-2 rounded flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Simpan Tarif
                </button>

                <a href="?action=manage-tarif"
                class="flex-1 flex items-center justify-center gap-2 border border-cyan-400 text-cyan-400
                        hover:bg-cyan-500 hover:text-slate-900 rounded px-4 py-2 transition">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>

</body>
</html>