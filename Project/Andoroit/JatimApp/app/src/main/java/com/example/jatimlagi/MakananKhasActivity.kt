package com.example.jatimlagi

import android.content.Intent
import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView

class MakananKhasActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_makanan_khas)

        val recyclerView = findViewById<RecyclerView>(R.id.recyclerViewMakanan)
        recyclerView.layoutManager = LinearLayoutManager(this)

        val makananKhasList = listOf(
            MakananKhas("MALANG", R.drawable.malang),
            MakananKhas("SURABAYA", R.drawable.surabaya),
            MakananKhas("KEDIRI", R.drawable.kediri),
            MakananKhas("LUMAJANG", R.drawable.lumajang),
            MakananKhas("MADIUN", R.drawable.madiun),
            MakananKhas("SUMENEP", R.drawable.sumenep),
        )

        recyclerView.adapter = MakananKhasAdapter(makananKhasList) { makanan ->
            when (makanan.name) {
                "MALANG" -> startActivity(Intent(this, MalangSejarahActivity::class.java))
            }
        }
    }
}
