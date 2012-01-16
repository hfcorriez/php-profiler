<?php

class Profiler
{
    private static $_first_trace;
    private static $_last_trace;
    private static $_traces;
    private static $_traces_size = 0;
    
    private static $_is_win;
     
    public static function init()
    {
        register_tick_function(array('Profiler', '__tick'));
        self::$_is_win = substr(PHP_OS, 0, 3) == 'WIN';
    }
    
    public static function dump()
    {
        echo '<xmp>';
        print_r(self::$_traces);
        echo '</xmp>';
    }
    
    public static function __tick()
    {
        $start_time = self::__getCurrentTime();
        $start_memory = self::__getCurrentMemory();
        
        $trace = array();
        $trace['trace'] = debug_backtrace();
        $trace['time'] = self::__getCurrentTime();
        $trace['excute_time'] = self::__getExcuteTime($trace['time']);
        $trace['excute_time_all'] = self::__getExcuteTimeAll($trace['time']);
        $trace['memory'] = self::__getCurrentMemory();
        $trace['excute_memory'] = self::__getExcuteMemory($trace['memory']);
        $trace['excute_memory_all'] = self::__getExcuteMemoryAll($trace['memory']);
        self::$_traces[] = $trace;
        self::$_traces_size ++;
        
        if(!self::$_last_trace) self::$_first_trace = &self::$_traces[self::$_traces_size];
        self::$_last_trace = &self::$_traces[self::$_traces_size];
    }
    
    private static function __getCurrentTime()
    {
        return microtime(true);
    }
    
    private static function __getExcuteTime($start)
    {
        if(self::$_last_trace) return $start - self::$_last_trace['time'];
        return 0;
    }
    
    private static function __getExcuteTimeAll($start)
    {
        if(self::$_first_trace) return $start - self::$_first_trace['time'];
        return 0;
    }
    
    private static function __getCurrentMemory()
    {
        return memory_get_usage();
    }
    
    private static function __getExcuteMemory($start)
    {
        if(self::$_last_trace) return $start - self::$_last_trace['memory'];
        return 0;
    }
    
    private static function __getExcuteMemoryAll($start)
    {
        if(self::$_first_trace) return $start - self::$_first_trace['memory'];
        return 0;
    }
}