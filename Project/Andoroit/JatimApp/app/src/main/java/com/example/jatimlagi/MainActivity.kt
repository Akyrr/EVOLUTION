package com.example.jatimlagi

import android.content.Intent
import android.os.Bundle
import android.widget.ImageView
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        // --- RecyclerView untuk kota ---
        val recyclerViewCity = findViewById<RecyclerView>(R.id.recyclerViewCity)
        recyclerViewCity.layoutManager =
            LinearLayoutManager(this, LinearLayoutManager.HORIZONTAL, false)

        val cities = listOf(
            City("Malang", R.drawable.malang),
            City("Surabaya", R.drawable.surabaya),
            City("Kediri", R.drawable.kediri),
            City("Lumajang", R.drawable.lumajang),
            City("Madiun", R.drawable.madiun),
            City("Sumenep", R.drawable.sumenep),
        )

        recyclerViewCity.adapter = CityAdapter(cities)

        // --- Klik gambar Sejarah ---
        val imgSejarah = findViewById<ImageView>(R.id.imgSejarah)
        val imgWisata = findViewById<ImageView>(R.id.imgWisata)
        val imgMakanan = findViewById<ImageView>(R.id.imgMakanan)

        imgSejarah.setOnClickListener {
            startActivity(Intent(this, SejarahActivity::class.java))
        }

        imgWisata.setOnClickListener {
            startActivity(Intent(this, WisataActivity::class.java))
        }

        imgMakanan.setOnClickListener {
            startActivity(Intent(this, MakananKhasActivity::class.java))
        }

    }
    }
