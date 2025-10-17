package com.wideLancer.utils.handlers;

import org.apache.catalina.connector.ClientAbortException;
import org.springframework.stereotype.Service;
import jakarta.servlet.http.HttpServletResponse;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.OutputStream;
import java.io.RandomAccessFile;
import java.nio.file.Files;



@Service
public class HandlerStreams {
    private final int MaxBytes = 1024 * 1024 * 2; // dois megabytes

    public void enviarImagem(File img, HttpServletResponse res) throws IOException{
        if (!img.exists()){
            System.err.println("imagem: "+ img.getName() +" nao encontrada <404>");
            return;
        }
        FileInputStream Fin = new FileInputStream(img);
        int tamanho = Integer.parseInt(Long.toString(img.length()));

        byte[] bytes = new byte[tamanho];
        res.setHeader("Content-Type", "image/gif");
        Fin.read(bytes);

        OutputStream out = res.getOutputStream();
        out.write(bytes);
        Fin.close();
        out.close();
    }

    public void enviarDownloadArquivo(File prod, HttpServletResponse res, long chunkSize, long start, long end, long length) throws IOException {
        if (!prod.exists()) {
            System.err.println("Arquivo não encontrado: " + prod.getName());
            res.setStatus(HttpServletResponse.SC_NOT_FOUND);
            return;
        }

        if (start >= length || start > end) {
            res.setStatus(HttpServletResponse.SC_REQUESTED_RANGE_NOT_SATISFIABLE);
            res.setHeader("Content-Range", "bytes */" + length);
            return;
        }

        String mime = Files.probeContentType(prod.toPath());
        res.setContentType(mime != null ? mime : "application/zip");
        res.setHeader("Accept-Ranges", "bytes");
        res.setHeader("Content-Range", "bytes " + start + "-" + end + "/" + length);
        res.setHeader("Content-Length", String.valueOf(chunkSize));
        res.setHeader("Content-Disposition", "attachment; filename=\"" + prod.getName() + "\"");

        try (RandomAccessFile raf = new RandomAccessFile(prod, "r");
            OutputStream out = res.getOutputStream()) {

            raf.seek(start);
            byte[] buffer = new byte[MaxBytes];
            long bytesLeft = chunkSize;
            int bytesRead;

            while ((bytesRead = raf.read(buffer, 0, (int) Math.min(buffer.length, bytesLeft))) != -1 && bytesLeft > 0) {
                out.write(buffer, 0, bytesRead);
                bytesLeft -= bytesRead;
            }
            out.flush();
        } catch (ClientAbortException e) {
            System.out.println("Conexão cancelada pelo cliente.");
        } catch (IOException e) {
            System.err.println("Erro ao enviar arquivo: " + e.getMessage());
            e.printStackTrace();
        }
    }

}