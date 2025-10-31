package com.example.jatimlagi

import android.content.Intent
import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView

class SejarahActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_sejarah)

        val recyclerView = findViewById<RecyclerView>(R.id.recyclerViewSejarah)
        recyclerView.layoutManager = LinearLayoutManager(this)

        val sejarahList = listOf(
            Sejarah("MALANG", R.drawable.malang),
            Sejarah("SURABAYA", R.drawable.surabaya),
            Sejarah("KEDIRI", R.drawable.kediri),
            Sejarah("LUMAJANG", R.drawable.lumajang),
            Sejarah("MADIUN", R.drawable.madiun),
            Sejarah("SUMENEP", R.drawable.sumenep),
        )

        // Set adapter dengan klik listener
        recyclerView.adapter = SejarahAdapter(sejarahList) { sejarah ->
            when (sejarah.name) {
                "MALANG" -> startActivity(Intent(this, MalangSejarahActivity::class.java))
            }
        }
    }
}
