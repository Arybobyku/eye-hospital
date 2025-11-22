<table style="width: 100%; border-collapse: collapse;">
    {{-- HEADER --}}
    <tr>
        <td style="border-bottom: 3px solid black; text-align: center;">
            <img style="width: 100%;" 
                 src="data:image/png;base64,{{ base64_encode(file_get_contents($fullpath)) }}" 
                 alt="Header Image" />
        </td>
    </tr>
</table>
<!DOCTYPE html>
<html>