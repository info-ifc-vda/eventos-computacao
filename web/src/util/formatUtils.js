/* @file Utilitários para formatação de dados
 * @module formatUtils
 * @description Este módulo contém funções utilitárias para formatar dados, como gerar links de mapas e formatar datas.
 * @author Fabricio Bizotto
 * @version 1.0.0
*/

/**
 * 
 * @param {string} mapsLink - Link do OpenStreetMap com parâmetros de latitude e longitude
 * @description Gera um link de embed para o OpenStreetMap a partir de um link com parâmetros de latitude e longitude.
 * @returns {string} - Link de embed do OpenStreetMap ou uma string vazia se os parâmetros não forem válidos.
 * @author Fabricio Bizotto
 * @version 1.0.0
 * @see {@link https://www.openstreetmap.org/export/embed.html} - Documentação do OpenStreetMap para embeds
 */
export function gerarEmbedMapa(mapsLink) {
    try {
        const url = new URL(mapsLink);
        const lat = parseFloat(url.searchParams.get("lat"));
        const lon = parseFloat(url.searchParams.get("lon"));
        if (!lat || !lon) return "";

        const delta = 0.001;
        const bbox = [lon - delta, lat - delta, lon + delta, lat + delta].join(",");

        return `https://www.openstreetmap.org/export/embed.html?bbox=${bbox}&layer=mapnik&marker=${lat},${lon}`;
    } catch (e) {
        console.warn("Erro ao gerar embed do mapa:", e);
        return "";
    }
}

/**
 * 
 * @param {string} isoDate - Data no formato ISO (YYYY-MM-DD)
 * @description Formata uma data no formato ISO (YYYY-MM-DD) para o formato "DD de Mês de YYYY" (ex: "01 de Janeiro de 2023").
 * @author Fabricio Bizotto
 * @version 1.0.0
 * @returns {string} - Data formatada ou uma string vazia se a data for inválida.
 * @see {@link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date/toLocaleDateString} - Documentação do método toLocaleDateString
 */
export function formatarData(isoDate) {
    if (!isoDate) return "";
    const [year, month, day] = isoDate.split("-");
    const dt = new Date(year, month - 1, day);
    return dt.toLocaleDateString("pt-BR", {
        day: "2-digit",
        month: "long",
        year: "numeric",
    });
}
