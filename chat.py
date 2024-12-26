import os
from flask import Flask, request, jsonify
from flask_cors import CORS
import google.generativeai as genai
import time #tambahan

app = Flask(__name__)
CORS(app)

genai.configure(api_key="AIzaSyCg2yeSttSF3jMWHTz0nt5B7Bn0oSBBIIY")

#tambahan untuk upload file
def upload_to_gemini(path, mime_type=None):
  """Uploads the given file to Gemini.

  See https://ai.google.dev/gemini-api/docs/prompting_with_media
  """
  file = genai.upload_file(path, mime_type=mime_type)
  print(f"Uploaded file '{file.display_name}' as: {file.uri}")
  return file
# sampai sini

#tambahan 2
def wait_for_files_active(files):
  """Waits for the given files to be active.

  Some files uploaded to the Gemini API need to be processed before they can be
  used as prompt inputs. The status can be seen by querying the file's "state"
  field.

  This implementation uses a simple blocking polling loop. Production code
  should probably employ a more sophisticated approach.
  """
  print("Waiting for file processing...")
  for name in (file.name for file in files):
    file = genai.get_file(name)
    while file.state.name == "PROCESSING":
      print(".", end="", flush=True)
      time.sleep(10)
      file = genai.get_file(name)
    if file.state.name != "ACTIVE":
      raise Exception(f"File {file.name} failed to process")
  print("...all files ready")
  print()
#end tambahan 2

# Menambahkan context FAQ rekrutmen
RECRUITMENT_CONTEXT = """
Anda adalah asisten virtual untuk portal lowongan kerja. Berikut adalah informasi FAQ terkait rekrutmen:

1. Proses Rekrutmen:
- Tahap 1: Seleksi Administrasi
- Tahap 2: Tes Kemampuan Dasar
- Tahap 3: Psikotes
- Tahap 4: Wawancara
- Tahap 5: Tes Kesehatan

2. Dokumen yang Dibutuhkan:
- CV terbaru
- Scan Ijazah & Transkrip
- Pas foto terbaru
- SKCK (jika diminta)
- Portofolio (untuk posisi tertentu)

3. Persyaratan Umum:
- WNI
- Sehat jasmani dan rohani
- Tidak terlibat narkoba
- Bersedia ditempatkan di seluruh Indonesia

4. Timeline Rekrutmen:
- Pendaftaran: 14 hari
- Seleksi Administrasi: 7 hari
- Tes & Wawancara: 14 hari
- Pengumuman: 7 hari

5. Informasi Tambahan:
- Semua proses rekrutmen tidak dipungut biaya
- Update status lamaran bisa dicek di dashboard
- Pelamar yang tidak lolos akan diberitahu via email
- Data pelamar disimpan dalam database untuk 6 bulan

Jawablah pertanyaan user dengan ramah dan profesional berdasarkan informasi di atas.
buatkan list jawaban dengan menggunakan format angka
"""

# Create the model
generation_config = {
  "temperature": 1,
  "top_p": 0.95,
  "top_k": 40,
  "max_output_tokens": 8192,
  "response_mime_type": "text/plain",
}

model = genai.GenerativeModel(
    model_name="gemini-2.0-flash-exp",
    generation_config=generation_config,
)

#tambahan 3
files = [
  upload_to_gemini("FAQ-Injobs.pdf", mime_type="application/pdf"),
]
files2 = [
  upload_to_gemini("FAQ-Injobs.csv", mime_type="text/csv"),
]

# Some files have a processing delay. Wait for them to be ready.
wait_for_files_active(files)
#end tambahan 3
chat_session = model.start_chat(
    history=[
        {"role": "user", "parts": [files[0], files2[0]]},
        {"role": "model", "parts": [RECRUITMENT_CONTEXT]},
    ]
)

@app.route('/chat', methods=['POST'])
def chat():
    message = request.json.get('message')
    response = chat_session.send_message(message)
    return jsonify({'response': response.text})

if __name__ == '__main__':
    app.run(debug=True)