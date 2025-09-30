import CsvBuilder from "./filify";
import setup from "../setup";
import axios from "axios";

let store_prefix = setup.store_prefix;

async function export_all_csv(data) {
  const confirmExport = await window.s_confirm("Export all");
  if (!confirmExport) return;

  window.start_loader();

  try {
    // Define the columns you want to include
    let columns = ["Account Category", "Title", "Amount"];
    let export_csv = new CsvBuilder(`income_list.csv`).setColumns(columns);

    // Extract the specific fields from the data
    const pageValues = data.map((item) => [
      item.account_category?.title || "N/A", // Safely access account_category.title
      item.title || "N/A", // Default to "N/A" if title is missing
      item.amount || 0, // Default to 0 if amount is missing
    ]);

    // Optional: Add a custom row, such as a total
    const customRow = ["Total", "All Income", data.reduce((sum, item) => sum + (item.amount || 0), 0)];
    const allValues = [...pageValues, customRow];

    // Update progress loader
    const progress = Math.round(Math.random() * 100);
    window.update_loader(progress);

    // Add rows and export the CSV
    export_csv.addRows(allValues);
    await export_csv.exportFile();
  } catch (error) {
    console.error("Error exporting CSV:", error);
    window.show_error("Failed to export data.");
  } finally {
    window.remove_loader();
  }
}

// Helper function to extract columns excluding unwanted keys
function extractColumns(dataObject, excludedKeys) {
  return dataObject ? Object.keys(dataObject).filter((key) => !excludedKeys.includes(key)) : [];
}

// Helper function to filter data and exclude unwanted keys
function filterData(dataObject, excludedKeys) {
  return Object.keys(dataObject)
    .filter((key) => !excludedKeys.includes(key))
    .map((key) => dataObject[key]);
}

// Loader functions to manage the progress UI
window.start_loader = function () {
  $(".loader").addClass("active");
  window.update_loader(5); // Set initial progress to 5%
};

window.update_loader = function (progress) {
  $(".load_amount h4").text(progress);
  $(".progress").css("width", progress + "%");
};

window.remove_loader = function () {
  $(".loader").removeClass("active");
  window.update_loader(5); // Reset progress to 5% when done
};

export default export_all_csv;
