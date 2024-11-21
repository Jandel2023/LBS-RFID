
@script
<script>
  window.addEventListener('DOMContentLoaded', () => {
    let isListening = @this.get('data.is_listening');

    let scanBtn = document.getElementById('uid-scan-btn');

    let stopListening = () => {
        isListening = false;
        @this.set('data.is_listening', false);
    }


    scanBtn.addEventListener('click', (e) => {

      e.preventDefault();

     if(isListening){
      stopListening();
     }else{
      @this.set('data.rfid', '');
      isListening = true;
      @this.set('data.is_listening', true);
     }
    });

    Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
          cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        });
        
        var channel = pusher.subscribe('rfid-channel');
        
        channel.bind('rfid-channel', function (data) {
          if (data.status == 200) {
            stopListening();
          }else{
            if(isListening){
              @this.set('data.rfid', data.rfid);
              stopListening();
            }
          }
         
        });
      })
      
      
      </script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endscript