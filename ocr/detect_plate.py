import cv2
import sys
import os
import imutils
import json

# ================= CONFIG
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
OUTPUT_DIR = os.path.join(BASE_DIR, "plates")
os.makedirs(OUTPUT_DIR, exist_ok=True)

# ================= INPUT
if len(sys.argv) < 2:
    print(json.dumps({"error": "NO_IMAGE"}))
    sys.exit(0)

image_path = sys.argv[1]

if not os.path.exists(image_path):
    print(json.dumps({"error": "FILE_NOT_FOUND"}))
    sys.exit(0)

# ================= LOAD IMAGE
image = cv2.imread(image_path)
if image is None:
    print(json.dumps({"error": "INVALID_IMAGE"}))
    sys.exit(0)

img_h, img_w = image.shape[:2]

# ================= PREPROCESS
gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
gray = cv2.bilateralFilter(gray, 11, 17, 17)
edged = cv2.Canny(gray, 50, 200)

# ================= FIND CONTOURS
cnts = cv2.findContours(edged, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
cnts = imutils.grab_contours(cnts)
cnts = sorted(cnts, key=cv2.contourArea, reverse=True)

candidates = []

# ================= CANDIDATE SELECTION
for c in cnts:
    x, y, w, h = cv2.boundingRect(c)
    area = w * h
    ratio = w / float(h)

    # ===== FILTER MOBIL & MOTOR (LONGGAR)
    if area < 1200:
        continue

    if not (1.8 <= ratio <= 6.0):
        continue

    # jangan terlalu atas
    if y < img_h * 0.15:
        continue

    score = area * ratio
    candidates.append((score, x, y, w, h, ratio))

# ================= FALLBACK MOTOR (PLAT KOTAK)
if not candidates:
    for c in cnts:
        x, y, w, h = cv2.boundingRect(c)
        area = w * h
        ratio = w / float(h)

        if area < 900:
            continue

        if not (1.2 <= ratio <= 2.5):
            continue

        score = area
        candidates.append((score, x, y, w, h, ratio))

# ================= VALIDASI
if not candidates:
    print(json.dumps({"error": "PLATE_NOT_FOUND"}))
    sys.exit(0)

# ================= PILIH TERBAIK
candidates = sorted(candidates, reverse=True)
_, x, y, w, h, ratio = candidates[0]

plate_img = image[y:y+h, x:x+w]

# ================= DETEKSI JENIS KENDARAAN
vehicle_type = "motor" if ratio < 3.2 else "mobil"

# ================= ROTATE JIKA TEGAK
if h > w:
    plate_img = cv2.rotate(plate_img, cv2.ROTATE_90_CLOCKWISE)

# ================= RESIZE OCR
plate_img = cv2.resize(
    plate_img,
    None,
    fx=2,
    fy=2,
    interpolation=cv2.INTER_CUBIC
)

# ================= SAVE
filename = f"plate_{os.path.basename(image_path)}"
plate_path = os.path.join(OUTPUT_DIR, filename)
cv2.imwrite(plate_path, plate_img)

# ================= OUTPUT JSON
print(json.dumps({
    "plate_path": plate_path,
    "vehicle_type": vehicle_type,
    "ratio": round(ratio, 2)
}))