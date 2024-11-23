import math
from turtle import *

# Fungsi untuk menghitung koordinat x dan y dari pola hati
def hearta(t):
    return 15 * math.sin(t) ** 3

def heartb(t):
    return 12 * math.cos(t) - 5 * math.cos(2 * t) - 2 * math.cos(3 * t) - math.cos(4 * t)

# Atur kecepatan dan warna latar belakang
speed(0)
bgcolor("black")
penup()
color("#ff3487")  # Atur warna garis

# Menggambar pola garis hati
for i in range(0, 360, 1):  # Iterasi dengan langkah lebih besar untuk efisiensi
    t = math.radians(i)  # Konversi derajat ke radian
    x = hearta(t) * 20  # Skala x
    y = heartb(t) * 20  # Skala y
    goto(x, y)
    pendown()

penup()

# Mengisi garis dengan pola garis vertikal
for i in range(0, 360, 1):  # Lebih sedikit iterasi untuk efisiensi
    t = math.radians(i)
    x = hearta(t) * 20
    y = heartb(t) * 20
    goto(x, y)
    pendown()
    goto(x, 0)  # Hubungkan setiap titik ke garis tengah
    penup()

done()
