package com.example.jatimlagi

import android.content.Intent
import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView

class WisataActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_wisata)

        val recyclerView = findViewById<RecyclerView>(R.id.recyclerViewWisata)
        recyclerView.layoutManager = LinearLayoutManager(this)

        val wisataList = listOf(
            Wisata("MALANG", R.drawable.malang),
            Wisata("SURABAYA", R.drawable.surabaya),
            Wisata("KEDIRI", R.drawable.kediri),
            Wisata("LUMAJANG", R.drawable.lumajang),
            Wisata("MADIUN", R.drawable.madiun),
            Wisata("SUMENEP", R.drawable.sumenep),
        )

        recyclerView.adapter = WisataAdapter(wisataList) { wisata ->
            when (wisata.name) {
                "MALANG" -> startActivity(Intent(this, MalangSejarahActivity::class.java))
            }
        }
    }
}
