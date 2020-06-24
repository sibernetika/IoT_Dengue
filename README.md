# IoT_Dengue
RISPRO IoT Dengue Research Project

Reserved for SARAS code Tracking
- Egg Counting
- Larva Counting
- Mosquito Indentification

Update tanggal 21 Juni 2020
- Egg dan larva counting sudah di update dengan menggunakan config.ini
- !! File IoTDengue.ini harus 1 folder dengan file python
- cara panggil : 
python Egg_Counting_V2.py --image [lokasi gambar] --parameter [jenis parameter] --node [nomor node]
python Larva_Counting_V2.py --image [lokasi gambar] --parameter [jenis parameter] --node [nomor node]
- dengan : 
lokasi gambar = lokasi tempat menyimpan gambar
jenis parameter = Egg_Counting/Larva_Counting
node = node_[nomor node] ; mis: node_1, node_20, dst
- additional notes : check kebutuhan rotasi / orientasi gambar